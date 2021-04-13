<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Http\Requests\VoteRequest;

class AnswerController extends Controller
{
    public function vote(Answer $answer, VoteRequest $request)
    {
        $answer->votes()->updateOrCreate([
            'answer_id' => $answer->id,
            'user_id' => $request->user_id
        ], [
            'vote' => $request->vote,
        ]);

        return $answer->refresh();
    }
}
