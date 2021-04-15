<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Http\Requests\VoteRequest;
use Illuminate\Http\Request;
use App\Models\Topic;

class AnswerController extends Controller
{
    public function index()
    {
        return Answer::with(['user', 'topic'])->get();
    }

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

    public function best(Answer $answer)
    {
        $oldBestAnswer = Answer::where('topic_id', $answer->topic_id)
            ->where('best_answer', true)
            ->first();

        if ($oldBestAnswer) {
            $oldBestAnswer->best_answer = false;
            $oldBestAnswer->save();
        }

        $answer->best_answer = true;
        $answer->save();
    }
}
