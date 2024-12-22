<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;

use App\Models\Buyer;
use App\Models\Game;
use App\Models\User;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\DeliveredPurchase;
use App\Models\PrePurchase;
use App\Models\CanceledPurchase;
use App\Models\OrderNotification;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class CheckoutController extends Controller
{

    public function __construct(NotificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }


    public function index(Request $request){
        if(auth_user()){
            if(auth_user()->buyer){
                $buyerId = auth_user()->id;
                $shoppingCartItems = ShoppingCart::where('buyer', $buyerId)->get();
                if ($shoppingCartItems->isEmpty()) {
                    return redirect()->route('shopping_cart')->withErrors('Your cart is empty.');
                }
            }
            else{
                return redirect()->route('home');
            }
        }
        else{
            return redirect()->route('home');
        }
        $products = [];
        $prePurchasedItems = [];
        $purchasedItems = [];
        $canceledItems = [];
        $games = [];
        $total = 0;
        $subtotal = 0;
        $coinsUsed = session('coins_to_use', 0);
        $coinsValue = $coinsUsed * 0.01;
        foreach ($shoppingCartItems as $cartItem) {
            $game = Game::find($cartItem->game);
            if (!$game) {
                return redirect()->route('shopping_cart')->withErrors('Some items are no longer available.');
            }
            $games[] = [
                'game' => $game,
                'stock' => $game->getStockAttribute()
            ];
            if($game->getReleaseDate() === 'Not realeased yet' || $game->getStockAttribute() === 0){
                for ($i = 0; $i < $cartItem->quantity; $i++) {
                    $prePurchasedItems[] = [
                        'game' => $game,
                        'gameId' => $game->id,
                        'gameName' => $game->name,
                        'value' => $game->price,
                    ];
                }
                $total += ($game->price * $cartItem->quantity);
                continue;
            }
            $availableCDKs = $game->getAvailableCDKs();
            $availableCDKs = $availableCDKs->slice(0, $cartItem->quantity);
            $total += ($game->price * $availableCDKs->count());
            foreach ($availableCDKs as $cdk) {
                $purchasedItems[] = [
                    'game' => $game,
                    'gameName' => $game->name,
                    'cdk' => $cdk->id,
                    'cdkCode' => $cdk->code,
                    'value' => $game->price,
                ];
            }
            if($availableCDKs->count() < $cartItem->quantity){
                $numberOfCanceledPurchases = $cartItem->quantity - $availableCDKs->count();
                while($numberOfCanceledPurchases > 0){
                    $canceledItems[] = [
                        'game' => $game->id,
                        'gameName' => $game->name,
                        'value' => 0,
                    ];
                    $numberOfCanceledPurchases--;
                }
            }
        }
        // Calculate the subtotal after applying coins
        $subtotal = $total - $coinsValue;
        if ($subtotal < 0.01) {
            $coinsUsed = floor(($total - 0.01) * 100);
            $coinsValue = $coinsUsed * 0.01;
            $subtotal = $total - $coinsValue;
        }
        $subtotal = round($subtotal,2);
        $paymentSuccessful = true;
        if (!$paymentSuccessful) {
            session()->forget('coins_to_use');
            return redirect()->route('cart.index')->withErrors('Payment failed.');
        }
        DB::beginTransaction();
        try {
            $payment = Payment::create([
                'method' => session('payment_method'),
                'value' => $subtotal,
            ]);
            $order = Order::create([
                'buyer' => $buyerId,
                'payment' => $payment->id,
                'coins' => $coinsUsed,
            ]);
            foreach ($purchasedItems as $purchasedItem) {
                $purchase = Purchase::create([
                    'value' => $purchasedItem['value'],
                    'order_' => $order->id,
                ]);
                DeliveredPurchase::create([
                    'id' => $purchase->id,
                    'cdk' => $purchasedItem['cdk'],
                ]);
            }
            foreach ($prePurchasedItems as $prePurchasedItem) {
                $purchase = Purchase::create([
                    'value' => $prePurchasedItem['value'],
                    'order_' => $order->id,
                ]);
                PrePurchase::create([
                    'id' => $purchase->id,
                    'game' => $prePurchasedItem['gameId'],
                ]);
            }
            foreach ($canceledItems as $canceledItem){
                $purchase = Purchase::create([
                    'value' => $canceledItem['value'],
                    'order_' => $order->id,
                ]);
                CanceledPurchase::create([
                    'id' => $purchase->id,
                    'game' => $canceledItem['game'],
                ]);
            }
            $order->refresh();
            session()->forget('payment_method');
            ShoppingCart::where('buyer', $buyerId)->delete();
            DB::commit();
            $this->notificationController->createOrderNotification($order, $prePurchasedItems, $purchasedItems, $canceledItems);
            $this->notificationController->createGameNotifications($prePurchasedItems, $purchasedItems);
            $this->soldOutNotifications($games);
            $purchasedCDKs = [];
            session()->forget('coins_to_use');
            return view('checkout.orderCompleted', ['purchasedItems' => $purchasedItems, 'prePurchasedItems' => $prePurchasedItems, 'canceledItems' => $canceledItems, 'subtotal' => $subtotal, 'coinsUsed' => $coinsUsed]);
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during checkout', [
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);
            session()->forget('coins_to_use');
            if (strpos($e->getMessage(), 'Buyer does not meet the minimum age requirement for this game') !== false) {
                return redirect()->route('shopping_cart')->withErrors('You do not meet the age requirement for one or more items in your cart.');
                $paymentSuccessful = true;
                if (!$paymentSuccessful) {
                    return redirect()->route('cart.index')->withErrors('Payment failed.');
                }
            }         
        }
    }

    function soldOutNotifications(array $games)
    {
        
        $uniqueGames = collect($games)
            ->unique(function ($item) {
                return $item['game']->id;
            })
            ->values()
            ->all();

        foreach ($uniqueGames as $gameData) {
            $game = $gameData['game'];
            $originalStock = $gameData['stock'];

            
            $currentStock = $game->getStockAttribute();

            // Step 3: Check if original stock > 0 and current stock == 0
            if ($originalStock > 0 && $currentStock == 0) {
                $this->notificationController->createStockNotifications($game, 'sold_out');
                echo "Notification triggered for game ID: {$game->id}\n";
            }
        }
    }


    public function selectPaymentMethod()
    {
        $paymentMethods = PaymentMethod::orderBy('name', 'asc')->get();
        return view('checkout.selectPaymentMethod', compact('paymentMethods'));
    }

    public function confirmPaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|exists:paymentmethod,id',
        ]);

        session(['payment_method' => $request->input('payment_method')]);

        return redirect()->route('checkout.index');
    }

    public function storeCoins(Request $request)
    {
        $request->validate([
            'coins_to_use' => 'integer|min:0|max:' . auth()->user()->buyer->coins,
        ]);

        $coinsToUse = $request->input('coins_to_use');

        // Store coins in the session
        session(['coins_to_use' => $coinsToUse]);

        return response()->json(['success' => true]);
    }

}

