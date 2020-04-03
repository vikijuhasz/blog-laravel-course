<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;


class User extends Authenticatable
{
    use Notifiable;

    public const LOCALES = [
        'en' => 'English',
        'es'=> 'Espanol',
        'de' => 'Deutsch'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function blogPosts()
    {
        return $this->hasMany('App\BlogPost');
    }
    
    // comments created by a particular user
    public function comments()
    {
        return $this->hasMany('App\Comment')->latest();
    }    
    
    // comments on a user
    public function commentsOn()
    {
        return $this->morphMany('App\Comment', 'commentable')->latest();
    }
    
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }
    
    public function scopeWithMostBlogPosts(Builder $query)
    {
        return $query->withCount('blogPosts')->orderBy('blog_posts_count', 'desc');
    }
    
    public function scopeWithMostBlogPostsLastMonth(Builder $query)
    {
        return $query->withCount(['blogPosts' => function (Builder $query) {
            $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]); 
        }])->has('blogPosts', '>=', 2)       
        ->orderBy('blog_posts_count', 'desc');
    }
    
    public function scopeThatHasCommentedOnPost(Builder $query, BlogPost $post)
    {
        return $query->whereHas('comments', function($query) use($post){
            return $query->where('commentable_id', '=', $post->id)
                    ->where('commentable_type', BlogPost::class);
        });
    }

    public function scopeThatIsAnAdmin(Builder $query)
    {
        return $query->where('is_admin', true);
    }
}
