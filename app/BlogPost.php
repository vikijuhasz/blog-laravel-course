<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Scopes\LatestScope;
use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use App\Traits\Taggable;

class BlogPost extends Model
{
     use SoftDeletes, Taggable;
    
    // protected $table = 'blogposts';     /* we manually add the expected table name so that Laravel does not make it from the model name, because in this case it would make it blog_posts, but our table name is blogposts */
    protected $fillable = ['title', 'content', 'user_id'];
    
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->latest();        
    }
         
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }
    
    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }
    
    public function scopeLatestWithRelations(Builder $query)
    {
        return $query->latest()
               ->withCount('comments')
               ->with('user')
               ->with('tags');
    }
    
    public static function boot()       // it will be automatically called by Laravel.
    {
        static::addGlobalScope(new DeletedAdminScope);        
        parent::boot();
                
//        // this closure will be always called before a blogpost is deleted
//        static::deleting(function (BlogPost $blogPost) {
//            $blogPost->comments()->delete();            // will delete all the related comments 
//            Cache::tags(['blog_post'])->forget("blog-post-{$blogPost->id}");
//        });
//        
//        static::restoring(function (BlogPost $blogPost) {
//           $blogPost->comments()->restore(); 
//        });
//        
//        static::updating(function(BlogPost $blogPost) {
//            Cache::tags(['blog_post'])->forget("blog-post-{$blogPost->id}");
//        });
    }    
}
