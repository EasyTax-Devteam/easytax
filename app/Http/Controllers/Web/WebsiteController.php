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
use App\Http\Controllers\Web\MpesaController;

class WebsiteController extends Controller
{
    public function index(){
        return view('web.welcome');
    }
    public function about(){
        return view('web.about');
    }
    public function file_return($id){
        if( intval($id) > 0 ){
            $service = Service::find($id);
            switch ( $service->type ) {
                case 'isNill':
                    Session::put('active_service', $service);
                    return redirect()->route('w.f.nill');
                    break;
                
                default:
                    return view('checkout.select_service');
                    break;
            }
        }
        return view('checkout.select_service');
    }
    public function file_Nill(){
        $service = Session::get('active_service');
        if(!$service){
            return redirect()->route('w.f.return', ['id' => 0]);
        }
        return view('checkout.nill', [
            'service' => $service,
        ]);
    }
    public function post_Nill(Request $request){
        $validator = Validator::make($request->all(), [ 
            'service' => 'required|string',
            'kraPin' => 'required|string|min:11|max:12|regex:/^[A-Z]{1}/|regex:/^[A-Z0-9]{10}[A-Z]$/',
            'itaxPassword' => 'required|string',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'phoneNumber' => 'required|string',
            'emailAddress' => 'required|email',
            'year' => 'required|string',
            'noTaxIncome' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $input = $request->all();
        DB::beginTransaction();
        try {
            $newCustomer = [
                'email' => $input['emailAddress'],
                'pin' => $input['kraPin'],
                'phone' => $input['phoneNumber'],
                'fname' => $input['firstName'],
                'lname' => $input['lastName'],
                'itax_password' => $input['itaxPassword'],
                'service' => $input['service']
            ];
            $customerId = null;
            if( $this->existsUser(trim($input['kraPin'])) ){
                $customer = $this->getExistingUser(trim($input['kraPin']));
                $customerId = $customer->id;
            }else{
                $customerId = Customer::create($newCustomer)->id;
            }
            $newOrder = [
                'customer' => $customerId,
                'pin' => $input['kraPin'],
                'itax_password' => $input['itaxPassword'],
                'has_taxable_income' => $input['noTaxIncome'],
                'service' => $input['service']
            ];
            $orderId = Order::create($newOrder)->id;
            $newBill = [
                'order' => $orderId,
                'narration' => 'initial bill',
                'amount' => $input['amount'],
                'payment_status' => false,
                'created_by' => $input['kraPin'],
            ];
            $billId = Bill::create($newBill)->id;
            Session::forget('active_service');
            Session::save();
            Session::put('bill_id', $billId);
            DB::commit();
            return redirect()->route('w.f.payform');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['Err' => $th->getMessage()]);
        }
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
                    return redirect()->route('w.f.return', ['id' => 0]);
                }
                Session::put('login_kra_pin', $customer);
                return redirect()->route('w.u.orders');
            }
            return response(['response' => $response ], 200);
        } catch (\Throwable $th) {
            return response(['response' => $th->getMessage()], 200);
        }
    }
    public function callback(){

    }
    protected function formatPhone($phone){
        return '254' . substr($phone, -9);
    }
    protected function existsUser($pin){
        return Customer::where('pin', $pin)->count() > 0;
    }
    protected function getExistingUser($pin){
        $data = Customer::where('pin', $pin)->first();
        if( is_object($data) ){
            return $data;
        }
        throw new \Exception("Error Processing Request. User does not really exist");
    }
}
