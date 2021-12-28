<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrderAssignment;
use App\Http\Controllers\Sms\SmsController;
use App\Mail\NewTask;
use App\Mail\NewBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewAccount;
use App\Models\Order;
use App\Models\User;
use App\Models\Bill;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function assign_order(Request $request ){
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [ 
                'admin' => 'required|string',
                'order' => 'required|string',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with([ 'Err' => 'Invalid  input fields', ]);
            }
            $input = $request->all();
            OrderAssignment::create($input);
            Order::find($input['order'])->update(['progress' => 'in_progress']);
            $user = User::find($input['admin']);
            $mail_data = [ 'name' => $user->name ];
            Mail::to($user->email)->send(new NewTask($mail_data));
            DB::commit();
            return redirect()->back()->with([ 'Msg' => 'Order assigned successfully!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with([ 'Err' => $th->getMessage() ]);
        }
    }
    public function update_status(Request $request ){
        try {
            $validator = Validator::make($request->all(), [  'new_status' => 'required|string', 'order' => 'required|string',]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->with([ 'Err' => 'Invalid  input fields', ]);
            }
            $input = $request->all();
            Order::find($input['order'])->update([ 'progress' => $input['new_status'] ]);
            return redirect()->back()->with([ 'Msg' => 'Order status changed successfully!']);
        } catch (\Throwable $th) {
            return redirect()->back()->with([ 'Err' => $th->getMessage() ]);
        }
    }
    public function add_bill(Request $request ){
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [ 
                'amount' => 'required|string',
                'narration' => 'required|string',
                'order' => 'required|string',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with([ 'Err' => 'Invalid  input fields' . json_encode($validator->errors()), ]);
            }
            $input = $request->all();
            $input['amount'] = abs($input['amount']);
            $input['created_by'] = 'admin';
            Bill::create($input);
            $order = Order::find($input['order']);
            $customer = Customer::find($order->customer);
            $mail_data = [ 'name' => $customer->fname ];
            $customer_sms = 'Hi ' . $customer->fname . ', a new bill of KES ' . number_format($input['amount']) . ' has been created. Visit ' . config('app.url') . 'users/access to complete payment';
            $advanta = new SmsController();
            $advanta->dispatchSms($customer->phone, $customer_sms);
            Mail::to($customer->email)->send(new NewBill($mail_data));
            DB::commit();
            return redirect()->back()->with([ 'Msg' => 'Bill created successfully! Customer has been notified']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with([ 'Err' => $th->getMessage() ]);
        }
    }

    public function orders(){
        return view('user.orders', [
            'orders' => $this->getOrders()
        ]);
    }

    public function order($id){
        return view('user.order_details', [
            'assigned' => $this->is_assigned($id),
            'user' => $this->getOrderAssignee($id),
            'admins' => $this->getUsers(2),
            'thisOrder' => Order::find($id),
            'bills' => $this->getOrderBills($id)
        ]);
    }

    protected function getOrderAssignee($order){
        if(!$this->is_assigned($order)){
            return null;
        }
        $data = OrderAssignment::where('order', $order)->first();
        $admin = $data->admin;
        return User::find($admin);
    }
    protected function is_assigned($order){
        return OrderAssignment::where('order', $order)->count() > 0;
    }
    protected function getOrders(){
        $data = Order::where('id', '>', 0)->orderBy('id', 'desc')->get();
        if( is_object($data) ){
            return $data->toArray();
        }
        return [];
    }
    protected function getOrderBills($order){
        $data = Bill::where('order', $order)->get();
        if( is_object($data) ){
            return $data->toArray();
        }
        return [];
    }
    protected function getUsers($case = 1){
        switch ($case) {
            case 1:
                $data = User::where('admin', true)->get();
                if( is_object($data) ){
                    return $data->toArray();
                }
                break;
            case 2:
                $data = User::where('admin', true)->where('enabled', true)->get();
                if( is_object($data) ){
                    return $data->toArray();
                }
                break;
            case 3:
                $data = User::where('admin', true)->where('enabled', false)->get();
                if( is_object($data) ){
                    return $data->toArray();
                }
                break;
        }
        return [];
    }
}
