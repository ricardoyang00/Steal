<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;

use App\Models\Buyer;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class checkoutController extends Controller
{
    public function index(){
        if(auth_user()){
            if(auth_user()->buyer){
                $buyerId = auth_user()->id;
                $shoppingCartItems = ShoppingCart::where('buyer', $buyerId)->get();
                if ($shoppingCartItems->isEmpty()) {
                    return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
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
        $purchasedItems = [];
        $canceledItems = [];
        $total = 0;
        foreach ($shoppingCartItems as $cartItem) {
            $game = Game::find($cartItem->game);
            if (!$game) {
                return redirect()->route('cart.index')->with('error', 'Some items are no longer available.');
            }
            $availableCDKs = $game->availableCDKs();
            if($availableCDKs->count < $cartItem->quantity){
                $canceledItems[] = [
                    'game' => $game->id,
                    'value' => 0.0,
                ];
            }
            foreach ($availableCDKs as $cdk) {
                $purchasedItems[] = [
                    'cdk' => $cdk->id,
                    'value' => $game->price,
                ];
            }
            $paymentSuccessful = true;
            if (!$paymentSuccessful) {
                return redirect()->route('cart.index')->with('error', 'Payment failed.');
            }
            DB::beginTransaction();
            try {
                $payment = Payment::create([
                    'method' => session('payment_method'),
                    'value' => $total,
                ]);
                $order = Orders::create([
                    'buyer' => $buyer->id,
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
                foreach ($canceledItems as $canceledItem){
                    $purchase = Purchase::create([
                        'value' => $canceledItem['value'],
                        'game' => $canceledItem['game'],
                    ]);
                }
                session()->forget('payment_method');
                ShoppingCart::where('buyer', $buyer->id)->delete();
                DB::commit();
                return view('pages.order_completed', ['purchasedItems' => $purchasedItems, 'canceledItems' => $canceledItems, 'total' => $total]);
            }
            catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('cart.index')->with('error', 'Something went wrong. Please try again.');
            }

        }

    }

    public function selectPaymentMethod()
    {
        $paymentMethods = PaymentMethod::all();
        return view('pages.payment.select', compact('paymentMethods'));
    }

    public function confirmPaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|exists:payment_methods,id',
        ]);

        session(['payment_method' => $request->input('payment_method')]);

        return redirect()->route('checkout.index');
    }

}