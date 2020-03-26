<?php
        
namespace App\Http\ViewComposers;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use App\User;
use App\BlogPost;

class ActivityComposer 
{
    public function compose(View $view)
    {
        $mostCommented = Cache::tags(['blog_post'])->remember('mostCommented', 60, function () {
            return BlogPost::mostCommented()->take(5)->get();            
        });
        
        $mostActive = Cache::remember('mostActive', 60, function () {
            return User::withMostBlogPosts()->take(5)->get();
        });
        
        $mostActiveLastMonth = Cache::remember('mostActiveLastMonth', 60, function () {
            return User::WithMostBlogPostsLastMonth()->take(5)->get();
        });
        
        $view->with('mostCommented', $mostCommented);
        $view->with('mostActive', $mostActive);
        $view->with('mostActiveLastMonth', $mostActiveLastMonth);
    }
}