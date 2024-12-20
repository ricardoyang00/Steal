<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ReviewLike;
use App\Models\User;
use App\Models\Reason;
use App\Models\Report;

class ReportedReviewController extends Controller {
    public function index()
    {
        $reportedReviews = Report::with(['buyer', 'review', 'reason'])->paginate(10);
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