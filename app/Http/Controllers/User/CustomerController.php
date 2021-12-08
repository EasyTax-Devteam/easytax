<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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
            'all' => $this->getCustomers(),
        ]);
    }
    protected function getCustomers(){
        $data = Customer::all();
        if( is_object($data) ){
            return $data->toArray();
        }
    }
}
