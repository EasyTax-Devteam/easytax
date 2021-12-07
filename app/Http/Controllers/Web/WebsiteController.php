<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Validator;
use App\Http\Controllers\Web\MpesaController;

class WebsiteController extends Controller
{
    public function index(){
        return view('web.welcome');
    }
    public function about(){
        return view('web.about');
    }
    
    public function payform(){
        $billId = Session::get('bill_id');
        $bill = Bill::find($billId);
        if(!$billId){
            return redirect()->route('w.f.return', ['id' => 0]);
        }
        return view('checkout.pay', [
            'bill' => $billId,
            'amount' => $bill->amount
        ]);
    }
    public function post_Pay(Request $request){
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
                10,//$bill->amount,
                $mpesaPhone,
                route('mpesa.callback'),
                $billId,
                config('app.name'),
                'Easytax order'
            );
            $response = $mpesa->TriggerStkPush();
            $response = json_decode($response);
            if($response->ResponseCode == '0'){
                Session::put('CheckoutRequestID', $response->CheckoutRequestID);
                $bill->mpesa_checkout_id = $response->CheckoutRequestID;
                $bill->save();
                return redirect()->back()->withInput()->with(['Msg' => 'Payment notification has been send to your phone. Please enter your PIN to complete your order']);
            }
            return redirect()->back()->withInput()->with(['Err' => 'Error Sending Payment notification. Please try again']);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with(['Err' => $th->getMessage() ]);
        }
    }
    public function checkStatus(Request $request){
        try {
            $mpesa = new MpesaController(
                config('app.app_mpesa_c_key'),
                config('app.app_mpesa_c_secret'),
                config('app.app_mpesa_paybill'),
                config('app.app_mpesa_passkey'),
                config('app.app_mpesa_env')
            );
            $CheckoutRequestID = Session::get('CheckoutRequestID');
            $json = $mpesa->QueryStkStatus($CheckoutRequestID);
            $res = json_decode($json);
            $response = $res;
            $responseCode = $response->ResponseCode;
            $resultCode = $response->ResultCode;
            if( $resultCode == '0'){
                $bill = Bill::where('mpesa_checkout_id', $CheckoutRequestID)->first();
                $kra = $bill->created_by;
                $bill->payment_status = true;
                $bill->mpesa_log = $json;
                $bill->save();
                $customer = Customer::where('pin', $kra)->first();
                if( !is_object($customer) ){
                    return response(['Err' => 'failed login', 'Url' => route('w.u.login') ], 200);
                }
                Session::put('login_kra_pin', $customer);
                return response(['Msg' => 'logged', 'Url' => route('w.u.orders') ], 200);
            }
            throw new \Exception("Payment not completed yet. Please wait and try again in 2minutes");
        } catch (\Throwable $th) {
            return response(['Err' => $th->getMessage()], 200);
        }
    }
    public function callback(){

    }
    protected function formatPhone($phone){
        return '254' . substr($phone, -9);
    }
}
