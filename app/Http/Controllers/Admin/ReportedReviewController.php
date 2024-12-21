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
        ->join('users as authors', 'review.author', '=', 'authors.id')
        ->join('reason', 'report.reason', '=', 'reason.id')
        ->join('game', 'review.game', '=', 'game.id')
        ->select(
            'report.id as report_id',
            'users.id as buyer_id',
            'users.username as buyer_username',
            'reason.description as reason_description',
            'report.description as report_description',
            
            'game.id as game_id',
            'game.name as game_name',
            
            'review.id as review_id',
            'authors.id as author_id',
            'authors.username as author_username',
            'review.title as review_title',
            'review.description as review_description',
        )
        ->paginate(10);

        return view('admin.reviews.reported-reviews', compact('reportedReviews'));
    }

    public function destroyReview($id)
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

    public function destroyReport($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Report deleted successfully.');
    }
}