<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;

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

        $reviews = $reviews->toArray();

        return response()->json([
            'reviews' => $reviews,

        ]);
    }

    public function addReview(Request $request)
    {
        $review = new Review();
        $review->title = $request->input('title');
        $review->game = $request->input('game_id');
        $review->description = $request->input('description');
        $review->positive = $request->input('positive');
        $review->author = auth_user()->id;

        $review->save();

        return response()->json([
            'success' => true,
        ]);
    }

}
