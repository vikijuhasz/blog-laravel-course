<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\BlogPost;
use App\Events\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Http\Resources\Comment as CommentResource;

use App\Jobs\ThrottledMail;

class PostCommentController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth')->only(['store']);
    }
    
    public function index(BlogPost $post)
    {
        // return $post->comments;
        // return new CommentResource($post->comments->first());
        // return CommentResource::collection($post->comments);
        return CommentResource::collection($post->comments()->with('user')->get());
        // return $post->comments()->with('user')->get();
    }
    
    public function store(BlogPost $post, StoreComment $request)
    {
        // Comment::create();
        $comment = $post->comments()->create([
            'content' => $request->input('content'), 
            'user_id' => $request->user()->id
        ]);
        
//        Mail::to($post->user)->send(
//            new CommentPostedMarkdown($comment)    
//        );
        
//        Mail::to($post->user)->queue(
//            new CommentPostedMarkdown($comment)    
//        );  

        event(new CommentPosted($comment));

        // ThrottledMail::dispatch(new CommentPostedMarkdown($comment), $post->user)
        //         ->onQueue('high');
        
        // NotifyUsersPostWasCommented::dispatch($comment)
        //         ->onQueue('low');

        // $when = now()->addMinutes(1);
        
        // Mail::to($post->user)->later(
        //     $when,
        //     new CommentPostedMarkdown($comment)    
        // );
        
         return redirect()->back()
                ->withStatus('Comment was created');
    }
}
