<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ReviewLike;
use App\Models\User;
use App\Models\Game;
use App\Models\Reason;
use App\Models\Report;
use App\Http\Controllers\GameController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReviewsController extends Controller
{

    public function __construct(NotificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }

    public function addReview(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s,\.]+$/',
            'description' => 'required|string|max:500|regex:/^[a-zA-Z0-9\s,\.]+$/',
        ]);        

        try {
            $review = new Review();
            $review->title = $request->input('title');
            $review->game = $request->input('game_id');
            $review->description = $request->input('description');
            $review->positive = $request->input('rating');
            $review->author = auth_user()->id;
            $review->save();


            $gameId = $request->input('game_id');
            $game = Game::find($gameId);
            $game->save();


        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while adding the review.']);
        }
        $this->notificationController->createReviewNotifications($review);
        return redirect()->route('game.details', ['id' => $gameId])->withSuccess('Review added successfully!');
    }

    public function deleteReview($id)
    {
        try {
            $review = Review::findOrFail($id);
            $gameId = $review->game;

            // Delete related reports
            Report::where('review', $id)->delete();

            // Delete related likes
            ReviewLike::where('review', $id)->delete();

            $review->delete();
    
            $game = Game::findOrFail($gameId);
            $game->save();
    
            return redirect()->route('game.details', ['id' => $gameId])->withSuccess('Review removed successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while removing the review.']);
        }
    }

    public function updateReview(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s,\.]+$/',
            'description' => 'required|string|max:500|regex:/^[a-zA-Z0-9\s,\.!]+$/',
        ]);        

        try {
            $reviewId = $request->input('review_id');

            $review = Review::findOrFail($reviewId);


            $review->title = $request->input('title');
            $review->description = $request->input('description');
            $review->positive = $request->input('rating');
            $gameId = $review->game;
            $review->save();

            $game = Game::find($gameId);
            $game->save();

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while updating the review.']);
        }

        return redirect()->route('game.details', ['id' => $gameId])->withSuccess('Review updated successfully!');
    }

    public function like(Request $request, $reviewId)
    {
        $user = auth_user();
        if (!$user) {
            return redirect()->route('login');
        }
    
        $review = Review::findOrFail($reviewId);
    
        // Check if the user has already liked the review
        $existingLike = ReviewLike::where('review', $reviewId)->where('author', $user->id)->first();
        if ($existingLike) {
            // Unlike the review
            $existingLike->delete();
            \Log::info("User {$user->id} unliked review {$reviewId}");
        } else {
            // Create a new like
            ReviewLike::create([
                'review' => $reviewId,
                'author' => $user->id,
            ]);
            \Log::info("User {$user->id} liked review {$reviewId}");
        }
    
        // Get the updated likes count
        $likesCount = $review->likes()->count();
        \Log::info("Review {$reviewId} now has {$likesCount} likes");
    
        return response()->json(['success' => true, 'likes_count' => $likesCount]);
    }

    public function reportReview(Request $request)
    {
        $request->validate([
            'review_id' => 'required|integer',
            'reason_id' => 'nullable|integer',
            'description' => 'nullable|string|max:500',
        ]);

        if (is_null($request->input('reason_id')) && is_null($request->input('description'))) {
            return back()->withErrors(['error' => 'You must provide either a reason or a description.']);
        }

        try {
            $reviewId = $request->input('review_id');
            $reasonId = $request->input('reason_id');

            $review = Review::findOrFail($reviewId);
            $buyerId = auth()->id();

            // Check if a report already exists
            $existingReport = Report::where('buyer', $buyerId)
                ->where('review', $reviewId)
                ->first();
    
            if ($existingReport) {
                return back()->withErrors(['error' => 'You have already reported this review.']);
            }

            // Create a new report
            Report::create([
                'buyer' => auth()->id(),
                'review' => $reviewId,
                'reason' => $reasonId,
                'description' => $request->input('description'),
                'report_time' => Carbon::now(),
            ]);

            return back()->withSuccess('Review reported successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while reporting the review.']);
        }
    }
}