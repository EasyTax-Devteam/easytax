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
    public function orders()
    {
        $pin = Session::get('login_kra_pin');
        if (!$pin) {
            return redirect()->route('w.u.login');
        }
        $customer = Customer::where('pin', $pin)->first();
        if (!is_object($customer)) {
            return redirect()->route('w.u.login');
        }
        $orderIDs = $this->getOrderIDs($customer->id);
        return view('customer.orders', [
            'orders' => $this->getOrders($customer->id),
            'bills' => $this->getBills($orderIDs),
            'services' => $this->getServices(),
            'customer' => $customer
        ]);
    }
    protected function getServices()
    {
        $data = Service::all();
        if (!is_object($data)) {
            return [];
        }
        return $data->toArray();
    }
    protected function getOrders($customer)
    {
        $data = Order::where('customer', $customer)->get();
        if (!is_object($data)) {
            return [];
        }
        return $data->toArray();
    }
    protected function getBills($orders)
    {
        $data = Bill::whereIn('order', $orders)->get();
        if (!is_object($data)) {
            return [];
        }
        return $data->toArray();
    }
    protected function getOrderIDs($customer)
    {
        $data = Order::select('id')->where('customer', $customer)->get();
        if (!is_object($data)) {
            return [];
        }
        return $data->toArray();
    }

    public function login()
    {
        return view('customer.login');
    }

    public function post_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'KraPin' => 'required|string|min:11|max:12|regex:/^[A-Z]{1}/|regex:/^[A-Z0-9]{10}[A-Z]$/',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $kra = $request->get('KraPin');
        $customer = Customer::where('pin', $kra)->first();
        if (!is_object($customer)) {
            return redirect()->route('w.f.return', ['id' => 0]);
        }
        Session::put('login_kra_pin', $customer);
        return redirect()->route('w.u.orders');
    }

    public function logout()
    {
        Session::forget('login_kra_pin');
        Session::save();
        return redirect()->route('w.u.login');
    }
}
