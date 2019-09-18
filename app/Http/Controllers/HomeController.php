<?php

namespace App\Http\Controllers;

use Cartalyst\Alerts\Native\Facades\Alert;
use Illuminate\Http\Request;
use Session;

class HomeController extends Controller
{
//-----------------------------------Landing Page----------------------------------------------//
    function index()
    {
        return view('admin.dashboard');
    }
//---------------------------------------------------------------------------------------------//
    public function users()
    {
        print_r(Session::get('login'));
        if(!Session::get('login')){
            Alert::error('Error message', 'right-sidebar');
            return redirect('login');
        }else{
        return view('admin.welcome');
        }
    }
    public function login()
    {
        return view('login');
    }
    public function loginPost(Request $request)
    {
        $uid = $request->userid;
        $email = $request->email;
        $password = $request->password;

        Session::put('uid',$uid);
        Session::put('email',$email);
        Session::put('password',$password);
        Session::put('login',TRUE);
        echo 1;
    }    
    public function pending()
    {
        print_r(Session::get('login'));
        if(!Session::get('login')){
            Alert::error('Error message', 'right-sidebar');
            return redirect('login');
        }else{
        return view('admin.pending');
        }
    }
}
