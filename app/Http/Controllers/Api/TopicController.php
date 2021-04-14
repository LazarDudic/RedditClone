<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Http\Requests\VoteRequest;
use App\Http\Requests\CreateTopicRequest;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->category_id;

        $topics = Topic::with(['answers', 'user'])
            ->when($categoryId, function($q, $categoryId) {
                 return $q->where('category_id', $categoryId);
             })
            ->latest()
            ->get();

        return $this->sortTopics($topics, $request->sort_field, $request->direction);
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

    public function store(CreateTopicRequest $request)
    {
        $topic = Topic::create($request->validated());

        return $topic->load('user', 'answers');
    }

    public function update(CreateTopicRequest $request, Topic $topic)
    {
        $topic->update($request->validated());

        return $topic->load('user', 'answers');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();
    }

    public function sortTopics($topics, $field, $direction)
    {
            if ($direction === 'asc') {
                $sorted = $topics->sortBy(function($topic) use ($field) {
                    return $topic->$field;
                });

                return $sorted->values()->all();
            } else if ('asc') {
                $sorted = $topics->sortByDesc(function($topic) use ($field) {
                    return $topic->$field;
                });

                return $sorted->values()->all();
            }

            return $topics;
    }

}
