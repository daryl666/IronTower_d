<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guard()->guest()) {
            return redirect('/login');
        } else {
            return view('backend/home/index');
        }

//        return view('home')->withArticles(\App\Models\Article::all());
//        return view('home')->with('articles', \App\Models\Article::all());
//        return view('home', ['articles' => \App\Models\Article::all()]);

    }


}
