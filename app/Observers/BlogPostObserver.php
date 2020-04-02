<?php

namespace App\Observers;

use App\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{
    public function updating(BlogPost $blogPost)
    {
        Cache::tags(['blog_post'])->forget("blog-post-{$blogPost->id}");
    }
    
    public function deleting (BlogPost $blogPost)
    {
        // dd('I am deleted');
        $blogPost->comments()->delete();            // will delete all the related comments 
        Cache::tags(['blog_post'])->forget("blog-post-{$blogPost->id}");        
    }
    
    public function restoring(BlogPost $blogPost)
    {
        $blogPost->comments()->restore();
    }
}
