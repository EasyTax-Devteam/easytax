<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Validator;
use App\Http\Controllers\Admin\MpesaController;

class UserController extends Controller
{
    public function orders(){
        $customer = Session::get('login_kra_pin');
        if( !$customer ){
            return redirect()->route('w.u.login');
        }
        return view('customer.orders');
    }

    public function login(){
        return view('customer.login');
    }

    public function post_login(Request $request){
        $kra = $request->get('KraPin');
        $customer = Customer::where('pin', $kra)->first();
        if( !is_object($customer) ){
            return redirect()->route('w.f.return', ['id' => 0]);
        }
        Session::put('login_kra_pin', $customer);
        return redirect()->route('w.u.orders');
    }

    public function logout(){
        Session::forget('login_kra_pin');
        Session::save();
        return redirect()->route('w.u.login');
    }
}
