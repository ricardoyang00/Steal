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


    public function index(){
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
        $total = 0;
        foreach ($shoppingCartItems as $cartItem) {
            $game = Game::find($cartItem->game);
            if (!$game) {
                return redirect()->route('shopping_cart')->withErrors('Some items are no longer available.');
            }
            if($game->getReleaseDate() === 'Not realeased yet'){
                for ($i = 0; $i < $cartItem->quantity; $i++) {
                    $prePurchasedItems[] = [
                        'game' => $game->id,
                        'gameName' => $game->name,
                        'value' => $game->price,
                    ];
                }
                $total += ($game->price * $cartItem->quantity);
                continue;
            }
            $availableCDKs = $game->getAvailableCDKs();
            if($availableCDKs->count() < $cartItem->quantity){
                $canceledItems[] = [
                    'game' => $game->id,
                    'gameName' => $game->name,
                    'value' => 0.0,
                ];
                continue;
            }
            $availableCDKs = $availableCDKs->slice(0, $cartItem->quantity);
            $total += ($game->price * $cartItem->quantity);
            foreach ($availableCDKs as $cdk) {
                $purchasedItems[] = [
                    'game' => $game,
                    'gameName' => $game->name,
                    'cdk' => $cdk->id,
                    'cdkCode' => $cdk->code,
                    'value' => $game->price,
                ];
            }
        }
            $paymentSuccessful = true;
            if (!$paymentSuccessful) {
                return redirect()->route('cart.index')->withErrors('Payment failed.');
            }
            DB::beginTransaction();
            try {
                $payment = Payment::create([
                    'method' => session('payment_method'),
                    'value' => $total,
                ]);
                $order = Order::create([
                    'buyer' => $buyerId,
                    'payment' => $payment->id,
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
                        'game' => $prePurchasedItem['game'],
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
                $this->notificationController->createOrderNotification($order, $prePurchasedItems, $purchasedItems, $canceledItems);
                $this->notificationController->createGameNotifications($purchasedItems);
                session()->forget('payment_method');
                ShoppingCart::where('buyer', $buyerId)->delete();
                DB::commit();
                $purchasedCDKs = [];
                return view('checkout.orderCompleted', ['purchasedItems' => $purchasedItems, 'prePurchasedItems' => $prePurchasedItems, 'canceledItems' => $canceledItems, 'total' => $total]);
            }
            catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error during checkout', [
                    'message' => $e->getMessage(),
                    'stack' => $e->getTraceAsString(),
                ]);
                return redirect()->route('shopping_cart')->withErrors('Something went wrong. Please try again.');
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

    


}

