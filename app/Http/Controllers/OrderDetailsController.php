<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;


class OrderDetailsController extends Controller{
    public function delete(Request $request)
    {
        // 1. Validate the incoming request data
        $validated = $request->validate([
            'pre_purchase_ids' => 'required|array|min:1',
            'pre_purchase_ids.*' => 'integer|exists:pre_purchase,id',
            'remove_order_count' => 'required|integer|min:1',
        ]);

        $prePurchaseIds = $validated['pre_purchase_ids'];
        $removeCount = $validated['remove_order_count'];

        if ($removeCount > count($prePurchaseIds)) {
            return response()->json([
                'message' => 'Remove count exceeds the number of selected pre-purchases.'
            ], 400);
        }

        // 3. Get the current authenticated user
        $user = auth_user()->id;

        if (!auth_user() || !auth_user()->buyer) {
            return response()->json([
                'message' => 'Unauthorized.'
            ], 401);
        }

        DB::beginTransaction();

        try {
            $prePurchases = PrePurchase::whereIn('id', $prePurchaseIds)
                ->whereHas('purchase.order', function ($query) use ($user) {
                    $query->where('buyer', $user->buyer->id);
                })
                ->limit($removeCount)
                ->get();

            if ($prePurchases->count() < $removeCount) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Not enough pre-purchases available to cancel.'
                ], 400);
            }

            foreach ($prePurchases as $prePurchase) {
                $purchase = $prePurchase->purchase;

                CanceledPurchase::create([
                    'id' => $purchase->id,
                    'game' => $prePurchase->game,
                ]);

                $prePurchase->delete();
            }

            DB::commit();

            return response()->json([
                'message' => 'Selected pre-purchases have been canceled successfully.'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'An error occurred while canceling pre-purchases.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}