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
        // Fetch the daily report data by default
        $sales = DeliveredPurchase::with(['getpurchase.getorder', 'getcdk.getgame'])
            ->whereHas('getpurchase.getorder', function ($query) {
                $query->whereDate('time', Carbon::today());
            })
            ->get()
            ->sortByDesc(function ($sale) {
                return $sale->getPurchase->getOrder->time;
            });

        $total = $sales->sum(function ($sale) {
            return $sale->getpurchase->value;
        });

        return view('admin.sales-report.index', compact('sales', 'total'));
    }


    public function daily()
    {
        $sales = DeliveredPurchase::with(['getpurchase.getorder', 'getcdk.getgame'])
            ->whereHas('getpurchase.getorder', function ($query) {
                $query->whereDate('time', Carbon::today());
            })
            ->get()
            ->sortByDesc(function ($sale) {
                return $sale->getPurchase->getOrder->time;
            });

        $total = $sales->sum(function ($sale) {
            return $sale->getpurchase->value;
        });

        return view('partials.admin.sales-report.daily', compact('sales', 'total'));
    }
    
    public function weekly()
    {
        $sales = DeliveredPurchase::with(['getpurchase.getorder', 'getcdk.getgame'])
            ->whereHas('getpurchase.getorder', function ($query) {
                $query->whereBetween('time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            })
            ->get()
            ->sortByDesc(function ($sale) {
                return $sale->getPurchase->getOrder->time;
            });
        $total = $sales->sum(function ($sale) {
            return $sale->getpurchase->value;
        });
        return view('partials.admin.sales-report.weekly', compact('sales', 'total'));
    }

    public function monthly()
    {
        $sales = DeliveredPurchase::with(['getpurchase.getorder', 'getcdk.getgame'])
            ->whereHas('getpurchase.getorder', function ($query) {
                $query->whereMonth('time', Carbon::now()->month());
            })
            ->get()
            ->sortByDesc(function ($sale) {
                return $sale->getPurchase->getOrder->time;
            });
        $total = $sales->sum(function ($sale) {
            return $sale->getpurchase->value;
        });
        return view('partials.admin.sales-report.monthly', compact('sales', 'total'));
    }

    public function custom(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        
        $sales = DeliveredPurchase::with(['getpurchase.getorder', 'getcdk.getgame'])
            ->whereHas('getpurchase.getorder', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('time', [$startDate, $endDate]);
            })
            ->get()
            ->sortByDesc(function ($sale) {
                return $sale->getPurchase->getOrder->time;
            });

        $total = $sales->sum(function ($sale) {
            return $sale->getpurchase->value;
        });

        return view('partials.admin.sales-report.custom', compact('sales', 'startDate', 'endDate', 'total'));
    }
    
    public function dailyContent()
    {
        return view('partials.admin.sales-report.daily');
    }

    public function weeklyContent()
    {
        return view('partials.admin.sales-report.weekly');
    }

    public function monthlyContent()
    {
        return view('partials.admin.sales-report.monthly');
    }

    public function customContent()
    {
        return view('partials.admin.sales-report.custom');
    }
}
