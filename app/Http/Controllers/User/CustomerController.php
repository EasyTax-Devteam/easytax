<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Site;
use App\Models\User;
use Illuminate\Support\Str;
use Storage;
use Validator;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function customers(){
        return view('user.customers', [
            'all' => [],
        ]);
    }
}
