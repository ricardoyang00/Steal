<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;
use App\Models\Game;
use App\Http\Controllers\GameController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Validator;

class ReviewsController extends Controller
{

    public function __construct(NotificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }

    public function addReview(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s]+$/',
            'description' => 'required|string|max:500|regex:/^[a-zA-Z0-9\s]+$/',
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
            $game->updateRatings();
            $game->save();


        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while adding the review.']);
        }
        $this->notificationController->createReviewNotifications($review);
        return redirect()->route('game.details', ['id' => $gameId])->with(['success' => 'Review added successfully!']);
    }

    public function deleteReview($id)
    {
        try {
            $review = Review::findOrFail($id);
            $gameId = $review->game;
            $review->delete();
    
            $game = Game::findOrFail($gameId);
            $game->updateRatings();
            $game->save();
    
            return redirect()->route('game.details', ['id' => $gameId])->withSuccess('Review removed successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while removing the review.']);
        }
    }

    public function updateReview(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s]+$/',
            'description' => 'required|string|max:500|regex:/^[a-zA-Z0-9\s]+$/',
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
            $game->updateRatings();
            $game->save();

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while updating the review.']);
        }

        return redirect()->route('game.details', ['id' => $gameId])->withSuccess('Review updated successfully!');
    }

    public function reportReview(Request $request)
    {
        $reviewId = $request->input('review_id');
        $review = Review::find($reviewId);
        $review->reported = true;
        $review->save();
        return response()->json([
            'success' => true,
        ]);
    }
}