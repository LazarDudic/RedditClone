<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Http\Requests\VoteRequest;

class TopicController extends Controller
{
    public function index()
    {
        return Topic::with(['answers', 'user'])->get();
    }

    public function show(Topic $topic)
    {
        $topic = $topic->load('user', 'answers');

        return $topic;
    }

    public function vote(Topic $topic, VoteRequest $request)
    {
        $topic->votes()->updateOrCreate([
            'topic_id' => $topic->id,
            'user_id' => $request->user_id
        ], [
            'vote' => $request->vote,
        ]);

        return $topic->refresh();
    }


}
