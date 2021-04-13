<?php

namespace App\Http\Controllers;

use App\Models\Topic;

class TopicController extends Controller
{
    public function show(Topic $topic)
    {
        $topic->increment('views');
        $topic = $topic->load('user', 'answers');

        return view('topic.show', compact('topic'));
    }
}
