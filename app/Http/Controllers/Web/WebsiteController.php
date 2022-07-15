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
use App\Http\Controllers\Sms\SmsController;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerWelcome;
use App\Mail\AdminPayment;
use App\Mail\CustomerPayment;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use App\Models\ServiceForm;
use App\Models\ServiceGroup;
use Storage;

class WebsiteController extends Controller
{

    public function index()
    {
        return view('web.welcome');
    }

    public function about()
    {
        return view('web.about');
    }

    public function single_service($id)
    {
        $service = Service::find($id);
        if (!is_object($service)) {
            abort(403);
        }
        $forms = ServiceForm::where('service', $id)->get();
        $forms->sort();
        if (!is_object($forms)) {
            abort(403);
        }
        $forms = $forms->toArray();

        return view('web.single_service', [
            'serviceData' => Service::find($id),
            'requestForm' => $forms
        ]);
    }

    public function single_category($id)
    {
        $data = [];
        $find = Service::where('enabled', true)->where('type', $id)->get();
        if (is_object($find)) {
            $data = $find->toArray();
        }
        return view('web.single_group', [
            'categoryData' => ServiceGroup::find($id),
            'services' => $data
        ]);
    }

    public function post_service(Request $request)
    {
        $serviceId = $request->get('service');
        DB::beginTransaction();
        try {
            $serviceFormFields = $this->getFormsByService($serviceId);
            $validationRules = $this->buildValidator($serviceFormFields);
            $validator = Validator::make($request->all(), $validationRules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            $predefinedInput = $request->all();
            $newCustomer = [
                'email' => $predefinedInput['email'],
                'phone' => $this->formatPhone($predefinedInput['phone']),
                'fname' => $predefinedInput['fname'],
                'lname' => $predefinedInput['lname'],
                'service' => $predefinedInput['service'],
            ];
            $input = [];

            foreach ($serviceFormFields as $_field) :
                switch (strtolower($_field['field_type'])) {
                    case 'text':
                        $checkker = $request->get($_field['field_name']);
                        if (strlen($checkker) > 0) {
                            $input[$_field['field_name']] = trim($request->get($_field['field_name']));
                            if (!array_key_exists('pin', $newCustomer)) {
                                if (str_contains($_field['field_name'], 'kra_pin')) {
                                    $newCustomer['pin'] = strtoupper(trim($request->get($_field['field_name'])));
                                }
                            }
                            if (!array_key_exists('itax_password', $newCustomer)) {
                                if (str_contains($_field['field_name'], '_password')) {
                                    $newCustomer['itax_password'] = strtoupper(trim($request->get($_field['field_name'])));
                                }
                            }
                        }
                        break;

                    case 'file':
                        $paths = [];
                        if ($_field['field_is_required'] == 1) {
                            if (!$request->hasfile($_field['field_name'])) {
                                return redirect()->back()->withInput()->with(['Err' => 'You must upload valid file(s) for ' . $_field['field_label']]);
                            }
                            if ($_field['field_is_multiple'] == 1) {
                                $files = $request->file($_field['field_name']);
                                foreach ($files as $key => $_file) :
                                    $extension = $_file->getClientOriginalExtension();
                                    $initial_name = preg_replace('/\PL/u', '_', $_file->getClientOriginalName());
                                    $original_name = str_replace('__', '_', $newCustomer['lname'] . '_' . $initial_name);
                                    if (!in_array(strtolower($extension), $this->allowedExtensions())) {
                                        return redirect()->back()->withInput()->with(['Err' => 'Error. Only valid files allowed e.g ' . implode(", ", $this->allowedExtensions())]);
                                    }
                                    $file_name = str_replace('__', '_', strtolower($original_name) . '_' . ($key + 1) . '_' . time() . '.' . $extension);
                                    Storage::disk('local')->putFileAs('customers', $_file, $file_name);
                                    $paths_entry = [
                                        'name' => strtolower($original_name) . '.' . $extension,
                                        'path' => $file_name
                                    ];
                                    array_push($paths, $paths_entry);
                                endforeach;
                            } elseif ($_field['field_is_multiple'] != 1) {
                                $file = $request->file($_field['field_name']);
                                $extension = $file->getClientOriginalExtension();
                                $initial_name = preg_replace('/\PL/u', '_', $file->getClientOriginalName());
                                $original_name = str_replace('__', '_', $newCustomer['lname'] . '_' . $initial_name);
                                if (!in_array(strtolower($extension), $this->allowedExtensions())) {
                                    return redirect()->back()->withInput()->with(['Err' => 'Error. Only valid files allowed e.g ' . implode(", ", $this->allowedExtensions())]);
                                }
                                $file_name = str_replace('__', '_', strtolower($original_name) . '_1_' . time() . '.' . $extension);
                                Storage::disk('local')->putFileAs('customers', $file, $file_name);
                                $path_entry = [
                                    'name' => strtolower($original_name) . '.' . $extension,
                                    'path' => $file_name
                                ];
                                array_push($paths, $path_entry);
                            }
                        } else {
                            if ($request->hasfile($_field['field_name'])) {
                                if ($_field['field_is_multiple'] == 1) {
                                    $files = $request->file($_field['field_name']);
                                    foreach ($files as $key => $_file) :
                                        $extension = $_file->getClientOriginalExtension();
                                        $initial_name = preg_replace('/\PL/u', '_', $_file->getClientOriginalName());
                                        $original_name = str_replace('__', '_', $newCustomer['lname'] . '_' . $initial_name);
                                        if (!in_array(strtolower($extension), $this->allowedExtensions())) {
                                            return redirect()->back()->withInput()->with(['Err' => 'Error. Only valid files allowed e.g ' . implode(", ", $this->allowedExtensions())]);
                                        }
                                        $file_name = str_replace('__', '_', strtolower($original_name) . '_' . ($key + 1) . '_' . time() . '.' . $extension);
                                        Storage::disk('local')->putFileAs('customers', $_file, $file_name);
                                        $paths_entry = [
                                            'name' => strtolower($original_name) . '.' . $extension,
                                            'path' => $file_name
                                        ];
                                        array_push($paths, $paths_entry);
                                    endforeach;
                                } elseif ($_field['field_is_multiple'] != 1) {
                                    $file = $request->file($_field['field_name']);
                                    $extension = $file->getClientOriginalExtension();
                                    $initial_name = preg_replace('/\PL/u', '_', $file->getClientOriginalName());
                                    $original_name = str_replace('__', '_', $newCustomer['lname'] . '_' . $initial_name);
                                    if (!in_array(strtolower($extension), $this->allowedExtensions())) {
                                        return redirect()->back()->withInput()->with(['Err' => 'Error. Only valid files allowed e.g ' . implode(", ", $this->allowedExtensions())]);
                                    }
                                    $file_name = str_replace('__', '_', strtolower($original_name) . '_1_' . time() . '.' . $extension);
                                    Storage::disk('local')->putFileAs('customers', $file, $file_name);
                                    $path_entry = [
                                        'name' => strtolower($original_name) . '.' . $extension,
                                        'path' => $file_name
                                    ];
                                    array_push($paths, $path_entry);
                                }
                            }
                        }
                        $input[$_field['field_name']] = $paths;
                        break;
                }
            endforeach;

            $input['additional_instructions'] = $request->get('additional_instructions');
            if (count($input) < 2) {
                return redirect()->back()->withInput()->with(['Err' => 'Error. You must provide some information to process the order ']);
            }

            $customerId = null;
            $existsUser = $this->existsUser($newCustomer);
            if ($existsUser) {
                $customer = $this->getExistingUser($newCustomer);
                $customerId = $customer->id;
            } else {
                $customerId = Customer::create($newCustomer)->id;
            }
            $newOrder = [
                'customer' => $customerId,
                'order_requested' => json_encode($input),
                'service' => $predefinedInput['service']
            ];
            $orderId = Order::create($newOrder)->id;
            $newBill = [
                'order' => $orderId,
                'narration' => 'initial bill',
                'amount' => $predefinedInput['amount'],
                'payment_status' => false,
                'created_by' => $customerId,
            ];
            $billId = Bill::create($newBill)->id;
            Session::put('bill_id', $billId);
            Session::put('last_service', $newCustomer['service']);
            if (!$existsUser) {
                $mail_data = ['name' => $newCustomer['fname'], 'pin' => $newCustomer['pin']];
                $customer_sms = 'Hi ' . $newCustomer['fname'] . ', your EasyTax account is set. Visit ' . config('app.url') . 'users/access to view your orders';
                $advanta = new SmsController();
                $advanta->dispatchSms($newCustomer['phone'], $customer_sms);
                Mail::to($newCustomer['email'])->send(new CustomerWelcome($mail_data));
            }
            DB::commit();
            return redirect()->route('w.f.payform');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['Err' => $th->getMessage()]);
        }
    }

    public function payform()
    {
        $billId = Session::get('bill_id');
        $last_service = Session::get('last_service');
        $bill = Bill::find($billId);
        if (!$billId) {
            return redirect()->route('w.s.service', ['id' => $last_service]);
        }
        return view('checkout.pay', [
            'bill' => $billId,
            'amount' => $bill->amount
        ]);
    }

    public function post_Pay(Request $request)
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

    public function checkStatus()
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
                if (!is_object($customer)) {
                    return response(['Err' => 'failed login', 'Url' => route('w.u.login')], 200);
                }
                Session::put('login_kra_pin', $customer);
                $mail_data = ['amount' => $amount, 'name' => $customer->fname];
                if ($bill->payment_status) {
                    $customer_sms = 'Hi ' . $customer->fname . ', your payment of KES ' . number_format($amount) . ' to EasyTax has been received';
                    $advanta = new SmsController();
                    $advanta->dispatchSms($customer->phone, $customer_sms);
                    Mail::to(config('mail.from.admin'))->send(new AdminPayment($mail_data));
                    Mail::to($customer->email)->send(new CustomerPayment($mail_data));
                }
                return response(['Msg' => 'logged', 'Url' => route('w.u.orders')], 200);
            }
            throw new \Exception("Payment not completed yet. Please wait and try again");
        } catch (\Throwable $th) {
            return response(['Err' => $th->getMessage()], 200);
        }
    }

    public function callback()
    {
        try {
            $data = file_get_contents("php://input");
            if (!$data) {
                return response(['ResultCode' => '1', 'ResultDesc' => 'Failed']);
            } else {
                Storage::disk('local')->prepend('mpesa.log', $data);
                /** callback urls */
                $paylog = json_decode($data, true);
                $stkCallback = $paylog['Body']['stkCallback'];
                $CheckoutRequestID = $stkCallback['CheckoutRequestID'];
                $bill = Bill::where('mpesa_checkout_id', $CheckoutRequestID)->first();
                if ($stkCallback['ResultCode'] == '0') //success
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
                    if (!$this->existsPayment($mpesaCode)) {
                        Payment::create($paymentEntry);
                    }
                    if (!$userCheckedStatus) {
                        $orderMeta = Order::find($bill->order);
                        $customer = Customer::find($orderMeta->customer);
                        $mail_data = ['amount' => $mpesaAmount, 'name' => $customer->fname];
                        $customer_sms = 'Hi ' . $customer->fname . ', your payment of KES ' . number_format($mpesaAmount) . ' to EasyTax has been received.';
                        $advanta = new SmsController();
                        $advanta->dispatchSms($customer->phone, $customer_sms);
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
    protected function existsPayment($mpesaCode)
    {
        return Payment::where('reference', $mpesaCode)->count() > 0;
    }
    protected function formatPhone($phone)
    {
        return '254' . substr($phone, -9);
    }

    protected function getFormsByService($service)
    {
        $forms = ServiceForm::where('service', $service)->get();
        $forms->sort();
        if (is_object($forms)) {
            return $forms->toArray();
        }
        throw new \Exception("No form fields found for service ID " . $service . ". Please contact EasyTax for assistance");
    }
    protected function buildValidator($forms)
    {
        $validator = [];
        foreach ($forms as $_form) :
            if (trim(strtoupper($_form['validation_rule'])) != 'NONE') {
                $validator[$_form['field_name']] = $_form['validation_rule'];
            }
        endforeach;
        return $validator;
    }
    protected function allowedExtensions()
    {
        return ['xlsx', 'xls', 'pdf', 'docs', 'doc', 'docx', 'csv', 'odt', 'jpg', 'jpeg', 'png'];
    }

    protected function existsUser($user)
    {
        return Customer::where('pin', $user['pin'])
            ->orWhere('email', $user['email'])
            ->orWhere('phone', $user['phone'])
            ->count() > 0;
    }

    protected function getExistingUser($user)
    {
        $data = Customer::where('pin', $user['pin'])
            ->orWhere('email', $user['email'])
            ->orWhere('phone', $user['phone'])
            ->first();
        if (is_object($data)) {
            return $data;
        }
        throw new \Exception("Error Processing Request. User does not really exist");
    }

    public function smstest()
    {
        $msg = new SmsController();
        // $resp = $msg->dispatchSms('0112384140');
        // print_r($resp);
    }
    public function email()
    {
        $data = [
            'pin' => 'A007jgjggjgjgjX',
            'name' => 'Juma james',
            'amount' => 100
        ];
        return view('emails.admin.payment', ['payload' => $data]);
        // return view('emails.customer.welcome', [ 'payload' => $data]);
    }
}
