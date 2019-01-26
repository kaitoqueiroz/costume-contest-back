<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Vote;
use App\UserCostume;
use Auth;

class VoteController extends Controller
{

    /**
     * Vote for a costume photo
     * and get the next not voted photo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function voteAndGetNext(Request $request)
    {
        $vote = new Vote([
            'user_id' => $request->input('user_id'),
            'voter' => Auth::guard()->user()->id,
            'vote' => $request->input('vote')
        ]);
        $vote->save();

        return $this->getNext();
    }

    /**
     * Get the next not voted photo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNext()
    {
        $nextUser = UserCostume::with('user')
        ->where('photo', '!=', null)
        ->where('user_id', '!=', Auth::guard()->user()->id)
        ->whereNotIn(
            'user_id',
            Vote::where(
                'voter', Auth::guard()->user()->id
            )
            ->pluck('user_id')
        )
        ->first();

        return response()->json($nextUser, 200);
    }
}
