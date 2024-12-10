<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\DeliveredPurchase;
use App\Models\Order;
use App\Models\CDK;
use Carbon\Carbon;

use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    public function index()
    {
        return view('admin.sales-report.index');
    }

    public function daily()
    {
        $sales = DeliveredPurchase::with(['getpurchase.getorder', 'getcdk.getgame'])
            ->whereHas('getpurchase.getorder', function ($query) {
                $query->whereDate('time', Carbon::today());
            })->get();
        return view('admin.sales-report.daily', compact('sales'));
    }

    public function weekly()
    {
        $sales = DeliveredPurchase::with(['getpurchase.getorder', 'getcdk.getgame'])
            ->whereHas('getpurchase.getorder', function ($query) {
                $query->whereBetween('time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            })->get();
        return view('admin.sales-report.weekly', compact('sales'));
    }

    public function monthly()
    {
        $sales = Purchase::whereMonth('created_at', Carbon::now()->month)->get();
        return view('admin.sales-report.monthly', compact('sales'));
    }

    public function custom(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        $sales = Purchase::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('admin.sales-report.custom', compact('sales', 'startDate', 'endDate'));
    }
}
