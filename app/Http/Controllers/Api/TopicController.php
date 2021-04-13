<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;

class TopicController extends Controller
{
    public function index()
    {
        return Topic::with(['answers', 'user'])->get();
    }

    public function show(Topic $topic)
    {
        $topic->increment('views');
        $topic = $topic->load('user', 'answers');

        return view('topic.show', compact('topic'));
    }
}
