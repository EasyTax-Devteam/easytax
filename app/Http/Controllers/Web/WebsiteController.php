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
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminPayment;
use App\Mail\CustomerPayment;
use App\Models\Order;
use App\Models\Payment;
use Storage;

class WebsiteController extends Controller
{
    public function index(){
        return view('web.welcome');
    }
    public function email(){
        $data = [
            'pin' => 'A007jgjggjgjgjX',
            'name' => 'Juma james',
            'amount' => 100
        ];
        return view('emails.admin.payment', [ 'payload' => $data]);
        // return view('emails.customer.welcome', [ 'payload' => $data]);
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
                $billStatus =  $bill->payment_status;
                $amount = $bill->amount;
                $bill->payment_status = true;
                $bill->mpesa_log = $json;
                $bill->save();
                $customer = Customer::where('pin', $kra)->first();
                if( !is_object($customer) ){
                    return response(['Err' => 'failed login', 'Url' => route('w.u.login') ], 200);
                }
                Session::put('login_kra_pin', $customer);
                $mail_data = [ 'amount' => $amount, 'name' => $customer->fname ];
                if( !$billStatus ){
                    Mail::to(config('mail.from.admin'))->send(new AdminPayment($mail_data));
                    Mail::to($customer->email)->send(new CustomerPayment($mail_data));
                }
                return response(['Msg' => 'logged', 'Url' => route('w.u.orders') ], 200);
            }
            throw new \Exception("Payment not completed yet. Please wait and try again in 2minutes");
        } catch (\Throwable $th) {
            return response(['Err' => $th->getMessage()], 200);
        }
    }
    protected function existsPayment($mpesaCode){
        return Payment::where('reference', $mpesaCode)->count() > 0;
    }
    public function callback(){
        try {
            $data = file_get_contents("php://input");
            if(!$data) {
                return response(['ResultCode' => '1', 'ResultDesc' => 'Failed']);
            }
            else{
                Storage::disk('local')->prepend('mpesa.log', $data);
                /** callback urls */
                $paylog = json_decode($data, true);
                $stkCallback = $paylog['Body']['stkCallback'];
                $CheckoutRequestID = $stkCallback['CheckoutRequestID'];
                $bill = Bill::where('mpesa_checkout_id', $CheckoutRequestID)->first();
                if( $stkCallback['ResultCode'] == '0' )//success
                {
                    $userCheckedStatus = $bill->payment_status;
                    $bill->payment_status = true;
                    $bill->mpesa_log = json_encode($paylog);
                    $bill->save();
                    $stk_meta_data = $stkCallback['CallbackMetadata']['Item'];
                    $mpesaCode = $stk_meta_data[1]['Value'];
                    $mpesaAmount = $stk_meta_data[0]['Value'];
                    $paidFromPhone = $stk_meta_data[4]['Value'];
                    $paymentEntry = [
                        'reference' => $mpesaCode,
                        'paid_by' => $paidFromPhone,
                        'amount' => $mpesaAmount,
                        'is_paid' => true,
                        'order' => $bill->id,
                        'mpesa_log' => json_encode($paylog)
                    ];
                    if( !$this->existsPayment($mpesaCode) ){
                        Payment::create($paymentEntry);
                    }
                    if( !$userCheckedStatus ){
                        $orderMeta = Order::find($bill->order);
                        $customer = Customer::find($orderMeta->customer);
                        $mail_data = [ 'amount' => $mpesaAmount, 'name' => $customer->fname ];
                        Mail::to(config('mail.from.admin'))->send(new AdminPayment($mail_data));
                        Mail::to($customer->email)->send(new CustomerPayment($mail_data));
                    }
                }
                /** end callbacks */
                return response(['ResultCode' => '0', 'ResultDesc' => 'Accepted Successfully']);
            }
        } catch (\Throwable $th) {
            Storage::disk('local')->prepend('mpesaErrors.log', $th->getMessage());
            return response(['ResultCode' => '0', 'ResultDesc' => 'Accepted Successfully']);
        }
    }
    protected function formatPhone($phone){
        return '254' . substr($phone, -9);
    }
}
