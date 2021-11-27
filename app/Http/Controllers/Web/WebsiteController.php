<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index(){
        return view('web.welcome');
    }
    public function about(){
        return view('web.about');
    }
    public function file_return($id){
        return view('checkout.step_one');
    }
}
