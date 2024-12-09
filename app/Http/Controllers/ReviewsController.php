<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;
use App\Models\Game;
use App\Http\Controllers\GameController;

class ReviewsController extends Controller
{
    public function getReviews(Request $request)
    {
        $gameId = $request->input('game_id');

        $reviews = Review::where('game', $gameId)->get();

        // get all author id in $reviews
        $authorIds = $reviews->pluck('author');

        for ($i = 0; $i < count($authorIds); $i++) {
            $authorNames[$i] = User::find($authorIds[$i])->name;
        }

        for ($i = 0; $i < count($reviews); $i++) {
            $reviews[$i]->author = $authorNames[$i];
        }

        return response()->json([
            'reviews' => $reviews,
        ]);
    }

    public function addReview(Request $request)
    {
        try {
            $review = new Review();
            $review->title = $request->input('title');
            $review->game = $request->input('game_id');
            $review->description = $request->input('description');
            $review->positive = $request->input('positive');
            $review->author = auth_user()->id;
            $review->save();


            $gameId = $request->input('game_id');
            $game = Game::find($gameId);
            $game->updateRatings();
            $game->save();


        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while adding the review.']);
        }

        return redirect()->route('game.details', ['id' => $gameId])->with(['success' => 'Review added successfully!']);
    }

    public function deleteReview(Request $request)
    {
        $reviewId = $request->input('review_id');

        $review = Review::find($reviewId);

        $gameId = $review->game;

        $review->delete();

        $game = Game::find($gameId);
        $game->updateRatings();
        $game->save();

        return response()->json([
            'success' => true,
        ]);
    }

    public function updateReview(Request $request)
    {
        try {
            $reviewId = $request->input('review_id');

            $review = Review::find($reviewId);


            $review->title = $request->input('title');
            $review->description = $request->input('description');
            $review->positive = $request->input('positive');
            $gameId = $review->game;
            $review->save();

            $game = Game::find($gameId);
            $game->updateRatings();
            $game->save();

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while updating the review.']);
        }

        return redirect()->route('game.details', ['id' => $gameId])->with(['success' => 'Review updated successfully!']);
    }
}
