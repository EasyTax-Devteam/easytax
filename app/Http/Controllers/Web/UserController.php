<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Session;
use Validator;
use App\Http\Controllers\Web\MpesaController;
use App\Http\Controllers\Sms\SmsController;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminPayment;
use App\Mail\CustomerPayment;

class UserController extends Controller
{
    public function orders()
    {
        $customer = Session::get('login_kra_pin');
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

    public function userPayform($id)
    {
        $billId = $id;
        $bill = Bill::find($billId);
        if (!$billId) {
            return redirect()->back();
        }
        return view('customer.pay', [
            'bill' => $billId,
            'amount' => $bill->amount,
            'customer' => Session::get('login_kra_pin')
        ]);
    }

    public function userPostPay(Request $request)
    {
        try {
            $billId = $request->get('bill');
            $mpesaPhone = $request->get('MpesaPhone');
            $mpesaPhone = $this->formatPhone($mpesaPhone);
            $bill = Bill::find($billId);
            $mpesa = new MpesaController(
                config('app.app_mpesa_c_key'),
                config('app.app_mpesa_c_secret'),
                config('app.app_mpesa_paybill'),
                config('app.app_mpesa_passkey'),
                config('app.app_mpesa_env'),
                config('app.app_mpesa_trans_type'),
                10, //$bill->amount,
                $mpesaPhone,
                route('mpesa.callback'),
                $billId,
                config('app.name'),
                'Easytax order'
            );
            $response = $mpesa->TriggerStkPush();
            $response = json_decode($response);
            if ($response->ResponseCode == '0') {
                Session::put('CheckoutRequestID', $response->CheckoutRequestID);
                $bill->mpesa_checkout_id = $response->CheckoutRequestID;
                $bill->save();
                return redirect()->back()->withInput()->with(['Msg' => 'Payment notification has been send to your phone. Please enter your PIN to complete your order']);
            }
            return redirect()->back()->withInput()->with(['Err' => 'Error Sending Payment notification. Please try again']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['Err' => $th->getMessage()]);
        }
    }

    public function userCheckStatus()
    {
        try {
            $mpesa = new MpesaController(
                config('app.app_mpesa_c_key'),
                config('app.app_mpesa_c_secret'),
                config('app.app_mpesa_paybill'),
                config('app.app_mpesa_passkey'),
                config('app.app_mpesa_env')
            );
            $CheckoutRequestID = Session::get('CheckoutRequestID');
            if (!strlen($CheckoutRequestID)) {
                return redirect()->back()->withInput()->with(['Err' => 'Error checking Payment status. Request Id not found']);
            }
            $json = $mpesa->QueryStkStatus($CheckoutRequestID);
            $res = json_decode($json);
            $response = $res;
            $resultCode = $response->ResultCode;
            if ($resultCode == '0') {
                $bill = Bill::where('mpesa_checkout_id', $CheckoutRequestID)->first();
                $customerId = $bill->created_by;
                $amount = $bill->amount;
                $bill->payment_status = true;
                $bill->mpesa_log = $json;
                $bill->save();
                $customer = Customer::find($customerId);
                $mail_data = ['amount' => $amount, 'name' => $customer->fname];
                if ($bill->payment_status) {
                    $customer_sms = 'Hi ' . $customer->fname . ', your payment of KES ' . number_format($amount) . ' to EasyTax has been received';
                    $advanta = new SmsController();
                    $advanta->dispatchSms($customer->phone, $customer_sms);
                    Mail::to(config('mail.from.admin'))->send(new AdminPayment($mail_data));
                    Mail::to($customer->email)->send(new CustomerPayment($mail_data));
                }
                return redirect()->back()->withInput()->with(['Msg' => 'Payment was successful. Thank you.']);
            }
            throw new \Exception("Payment not completed yet. Please wait and try again");
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['Err' => $th->getMessage()]);
        }
    }

    protected function formatPhone($phone)
    {
        return '254' . substr($phone, -9);
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
            return redirect()->route('w.index');
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
