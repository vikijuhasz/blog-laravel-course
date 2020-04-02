<?php

namespace App\Observers;

use App\Comment;
use App\BlogPost;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    public function creating(Comment $comment)
    {
        // dd('I am created');
        if ($comment->commentable_type === BlogPost::class) {
            Cache::tags(['blog_post'])->forget("blog-post-{$comment->commentable_id}");
            Cache::tags(['blog_post'])->forget("mostCommented");
        } 
    }
}
