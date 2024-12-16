<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ReviewLike;
use App\Models\User;
use App\Models\Game;
use App\Http\Controllers\GameController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            $review->delete();
    
            $game = Game::findOrFail($gameId);
            $game->save();
    
            return redirect()->route('game.details', ['id' => $gameId])->withSuccess('Review removed successfully!');
        } catch (\Exception $e) {
            Log::error('An error occurred while adding the review: ' . $e->getMessage(), ['exception' => $e]);

            return back()->withErrors(['error' => 'An error occurred while removing the review.']);
        }
    }

    public function updateReview(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s,\.]+$/',
            'description' => 'required|string|max:500|regex:/^[a-zA-Z0-9\s,\.]+$/',
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
        } else {
            // Create a new like
            ReviewLike::create([
                'review' => $reviewId,
                'author' => $user->id,
            ]);
        }
    
        // Get the updated likes count
        $likesCount = $review->likes()->count();
    
        return response()->json(['success' => true, 'likes_count' => $likesCount]);
    }
}