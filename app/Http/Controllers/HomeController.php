<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $admin = DB::table('users')->count();
        $students = DB::table('student')->count();
        $courses = DB::table('course')->count();
        return view('home',['admin'=>$admin,'courses'=>$courses,'students'=>$students]);
    }
}
