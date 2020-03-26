<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{    
    public function home()
    {
        // dd(Auth::id()); 
        // dd(Auth::user()); 
        // dd(Auth::check()); 
        return view('home');
    }
    
    public function contact()
    {
        return view('contact');
    }
    
    public function secret()
    {
        return view('secret');
    }
    
//    public function blogPost($id, $welcome = 1)
//    {
//        $pages = [
//        1 => [
//            'title' => 'page 1'
//        ],
//        2 => [
//            'title' => 'page 2'
//        ]
//        ];
//    
//        $welcomes = [1 => 'Hello from ', 2 => 'Welcome to'];
//        return view('/blog-post', [
//            'data' => $pages[$id]], 
//            ['welcome' => $welcomes[$welcome]
//        ]);
//    }
}
