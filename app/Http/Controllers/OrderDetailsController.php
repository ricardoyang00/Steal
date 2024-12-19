<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Purchase;
use App\Models\DeliveredPurchase;
use App\Models\PrePurchase;
use App\Models\CanceledPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderDetailsController extends Controller {
    public function cancelPrePurchases(Request $request)
    {
        // 1. Validate the incoming request data
        $validated = $request->validate([
            'pre_purchase_ids' => 'required|array|min:1',
            'pre_purchase_ids.*' => 'integer|exists:prepurchase,id', // Ensure table name matches your database
        ]);

        $prePurchaseIds = $validated['pre_purchase_ids'];
        $removeCount = count($prePurchaseIds); // Since each ID represents a cancellation

        // 2. Get the current authenticated user
        $user = auth_user(); // Correct user retrieval

        if (!auth_user() || !auth_user()->buyer) {
            return response()->json([
                'message' => 'Unauthorized.'
            ], 401);
        }

        DB::beginTransaction();

        try {

            // 3. Fetch the pre-purchase records to be canceled that belong to the current user
            $prePurchases = PrePurchase::whereIn('id', $prePurchaseIds)
                ->whereHas('getPurchase.getOrder', function ($query) use ($user) {
                    $query->where('buyer', auth_user()->id);
                })
                ->get();

            $order = $prePurchases->first()->getPurchase->getOrder->id;    

            // 4. Check if all provided pre_purchases belong to the user
            if ($prePurchases->count() !== $removeCount) {
                DB::rollBack();
                return redirect()->route('orderDetails', ['id' => $order])
                ->with('error', 'An error occured when trying to cancel the selected purchases!');
            }

            // 5. Process each pre-purchase
            foreach ($prePurchases as $prePurchase) {
                $purchase = $prePurchase->getPurchase;
                $payment = $prePurchase->getPurchase->getOrder->getPayment;

                if (!$purchase) {
                    throw new \Exception("Purchase not found for PrePurchase ID: " . $prePurchase->id);
                }

                if (!$payment) {
                    throw new \Exception("Payment not found for PrePurchase ID: " . $prePurchase->id);
                }

                $payment->value -= $purchase->value;
                $payment->save();

                $purchase->value = 0;
                $purchase->save();

                CanceledPurchase::create([
                    'id' => $purchase->id,
                    'game' => $prePurchase->game,
                ]);

                $prePurchase->delete();
            }

            DB::commit();

            return redirect()->route('orderDetails', ['id' => $order])
                ->with('success', 'Selected pre-purchases have been canceled successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error for debugging purposes
            \Log::error("Error canceling pre-purchases: " . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while canceling pre-purchases.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
