<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedRequest;
use App\Models\Comment;
use App\Models\Feed;
use App\Models\Like;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index()
    {
        $feeds = Feed::with('user')->latest()->get();
        return response([
            'feeds' => $feeds
        ], 200);
    }
    public function store(FeedRequest $request)
    {
        $request->validated();
        //$user_id = auth()->id();
        auth()->user()->feeds()->create([
            'body' => $request->body,
        ]);

        return response([
            'message' => 'success'
        ], 201);
    }

    public function likePost($feed_id)
    {
        $feed = Feed::whereId($feed_id)->first();

        if (!$feed){
            return response([
                'message' => '404 Not found'
            ], 500);
        }
        $unlike_post = Like::where('user_id', auth()->id())->where('feed_id', $feed_id)->delete();
        if ($unlike_post){
            return response([
                'message' => 'Unliked'
            ], 200);
        }
        //Like
        $like = Like::create([
            'user_id' => auth()->id(),
            'feed_id' => $feed_id
        ]);
        if ($like){
            return response([
                'message' => 'Liked'
            ], 200);
        }
    }

    public function comment($feed_id, Request $request)
    {
        $request->validate([
            'body' => ['required', 'min:6', 'max:1200', 'string']
        ]);
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'feed_id' => $feed_id,
            'body' => $request->body
        ]);

        return response([
            'message' => 'success'
        ], 200);
    }

    public function getComments($feed_id)
    {
        $comments = Comment::whereFeedId($feed_id)->with('user')->with('feed')->latest()->get();
        return response([
            'comments' => $comments
        ], 200);
    }
}
