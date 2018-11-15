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
     * Show the application Check Out Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		 $borrower   = DB::table('borrower')->select('*')->get();
		 
         return view('home',['borrower'=>$borrower]);
    }
	 /**
     * Show the application Check In Page.
     *
     * @return \Illuminate\Http\Response
     */
	public function checkIn()
    {
		
         return view('check-in');
    }
}
