<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use App\Traits\Taggable;

class Comment extends Model
{
    use SoftDeletes, Taggable;
    
    protected $fillable = ['user_id', 'content'];

   public function commentable()
   {
       return $this->morphTo();
   }
   
    public function user()
    {
        return $this->belongsTo('App\User');
    }    
        
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }    
    
    public static function boot()       // it will be automatically called by Laravel.
    {
        parent::boot();
        
        static::creating(function(Comment $comment) {
            if ($comment->commentable_type === BlogPost::class) {
            Cache::tags(['blog_post'])->forget("blog-post-{$comment->commentable_id}");
            Cache::tags(['blog_post'])->forget("mostCommented");
            }
        });
        
        // static::addGlobalScope(new LatestScope);
    }
}
