<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Http\Requests\VoteRequest;
use Illuminate\Http\Request;
use App\Models\Topic;

class AnswerController extends Controller
{
    public function store(Request $request, Topic $topic)
    {
        $answer = $topic->answers()->create($request->only('body', 'user_id'));

        return $answer->load('user');
    }

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
