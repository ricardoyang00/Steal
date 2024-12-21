<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ReviewLike;
use App\Models\User;
use App\Models\Reason;
use App\Models\Report;
use Illuminate\Support\Facades\DB;

class ReportedReviewController extends Controller {
    public function index()
    {
        $reportedReviews = DB::table('report')
        ->join('users', 'report.buyer', '=', 'users.id')
        ->join('review', 'report.review', '=', 'review.id')
        ->join('reason', 'report.reason', '=', 'reason.id')
        ->select(
            'report.id as report_id',
            'users.name as buyer_name',
            'reason.description as reason_description',
            'review.title as review_title',
            'report.description as report_description',
            'review.id as review_id'
        )
        ->paginate(10);

        return view('admin.reviews.reported-reviews', compact('reportedReviews'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Delete related reports
        Report::where('review', $id)->delete();

        // Delete related likes
        ReviewLike::where('review', $id)->delete();

        // Delete the review
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review and related data deleted successfully.');
    }
}