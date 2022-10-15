<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrderAssignment;
use App\Http\Controllers\Sms\SmsController;
use App\Mail\NewTask;
use App\Mail\NewBill;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\OrderDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminTaskReview;
use App\Mail\OrderComplete;
use App\Models\OrderArchive;
use Validator;
use Auth;
use Storage;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function assign_order(Request $request)
    {
        DB::beginTransaction();
        $assigner = Auth::user()->name;
        try {
            $validator = Validator::make($request->all(), [
                'admin' => 'required|string',
                'order' => 'required|string',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with(['Err' => 'Invalid  input fields',]);
            }
            $input = $request->all();
            $input['assigned_by'] = $assigner;
            OrderAssignment::create($input);
            Order::find($input['order'])->update(['progress' => 'in_progress']);
            $user = User::find($input['admin']);
            $mail_data = ['name' => $user->name];
            Mail::to($user->email)->send(new NewTask($mail_data));
            DB::commit();
            return redirect()->back()->with(['Msg' => 'Order assigned successfully!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with(['Err' => $th->getMessage()]);
        }
    }
    public function update_status(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), ['new_status' => 'required|string', 'order' => 'required|string',]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->with(['Err' => 'Invalid  input fields',]);
            }
            $input = $request->all();
            Order::find($input['order'])->update(['progress' => $input['new_status']]);
            return redirect()->back()->with(['Msg' => 'Order status changed successfully!']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['Err' => $th->getMessage()]);
        }
    }

    public function send_review(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), ['new_status' => 'required|string', 'order' => 'required|string',]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->with(['Err' => 'Invalid  input fields',]);
            }
            $input = $request->all();
            if ($input['new_status'] == 'in_progress') {
                return redirect()->back()->with(['Err' => 'Error. You cannot change status to ' . $input['new_status']]);
            }
            $order = Order::find($input['order']);
            if ($order->progress == 'in_review') {
                return redirect()->back()->with(['Err' => 'Error. This task is already in review']);
            }
            $order->update(['progress' => $input['new_status']]);
            $reviewers = explode(',', config('app.super_users'));
            if (is_array($reviewers) && count($reviewers) > 0) {
                Mail::to($reviewers)->send(new AdminTaskReview($order));
            }
            //mail
            DB::commit();
            return redirect()->back()->with(['Msg' => 'Task has been sent for review!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with(['Err' => $th->getMessage()]);
        }
    }
    public function mark_approved(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), ['order' => 'required|string',]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->with(['Err' => 'Invalid  input fields',]);
            }
            $input = $request->all();
            $order = Order::find($input['order']);
            if ($order->progress != 'in_review') {
                return redirect()->back()->with(['Err' => 'Error. This task cannot be approved. You can only approve a task that is in review']);
            }
            $order->update(['progress' => 'complete']);
            $customer = Customer::find($order->customer);
            if (is_object($customer)) {
                /** mail */
                $full_name = $customer->fname . ' ' . $customer->lname;
                $mail_data = ['name' => $full_name, 'order' => $order->id];
                Mail::to($customer->email)->send(new OrderComplete($mail_data));
                /** sms */
                $customer_sms = 'Hi ' . $full_name . ', your order number #' . $order->id . ' has been completed. Visit ' . config('app.url') . 'users/access to download your documents';
                $advanta = new SmsController();
                $advanta->dispatchSms($customer->phone, $customer_sms);
            }
            DB::commit();
            return redirect()->back()->with(['Msg' => 'Task has been approved and customer has been notified']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with(['Err' => $th->getMessage()]);
        }
    }
    public function add_bill(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required|string',
                'narration' => 'required|string',
                'order' => 'required|string',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with(['Err' => 'Invalid  input fields' . json_encode($validator->errors()),]);
            }
            $input = $request->all();
            $input['amount'] = abs($input['amount']);
            $input['created_by'] = 'admin';
            Bill::create($input);
            $order = Order::find($input['order']);
            $customer = Customer::find($order->customer);
            $mail_data = ['name' => $customer->fname];
            $customer_sms = 'Hi ' . $customer->fname . ', a new bill of KES ' . number_format($input['amount']) . ' has been created. Visit ' . config('app.url') . 'users/access to complete payment';
            $advanta = new SmsController();
            $advanta->dispatchSms($customer->phone, $customer_sms);
            Mail::to($customer->email)->send(new NewBill($mail_data));
            DB::commit();
            return redirect()->back()->with(['Msg' => 'Bill created successfully! Customer has been notified']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with(['Err' => $th->getMessage()]);
        }
    }

    public function addReturnDoc(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'order' => 'required|string',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with(['Err' => 'Invalid  input fields' . json_encode($validator->errors()),]);
            }
            $input = $request->all();
            $input['title'] = $this->createSlug($input['title']);
            $input['uploaded_by'] = Auth::user()->id;
            /** upload */
            $file = $request->file('path');
            $extension = $file->getClientOriginalExtension();
            $initial_name = preg_replace('/\PL/u', '_', $file->getClientOriginalName());
            $original_name = str_replace('__', '_', $input['title'] . '_' . $initial_name);
            if (!in_array(strtolower($extension), $this->allowedExtensions())) {
                return redirect()->back()->withInput()->with(['Err' => 'Error. Only valid files allowed e.g ' . implode(", ", $this->allowedExtensions())]);
            }
            $file_name = str_replace('__', '_', strtolower($original_name) . '_' . time() . '.' . $extension);
            Storage::disk('local')->putFileAs('customers', $file, $file_name);
            $input['path'] = $file_name;
            OrderDocument::create($input);
            return redirect()->back()->with(['Msg' => 'Document uploaded successfully!']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['Err' => $th->getMessage()]);
        }
    }
    public function dropDocument($id)
    {
        OrderDocument::find($id)->delete();
        return redirect()->back()->with(['Msg' => 'Document deleted']);
    }

    public function orders()
    {
        $unassigned = $this->getOrders('not_assigned');
        $inProgress = $this->getOrders('in_progress');
        $inReview = $this->getOrders('in_review');
        $approved = $this->getOrders('complete');
        return view('user.orders', [
            'unassigned' => $unassigned,
            'inProgress' => $inProgress,
            'inReview' => $inReview,
            'approved' => $approved
        ]);
    }

    public function order($id)
    {
        $pipelines = ['not_assigned', 'in_progress', 'in_review', 'complete'];
        if (Auth::user()->admin == 1) {
            $pipelines = ['in_progress', 'in_review'];
        }
        return view('user.order_details', [
            'assigned' => $this->is_assigned($id),
            'user' => $this->getOrderAssignee($id),
            'admins' => $this->getUsers(2),
            'thisOrder' => Order::find($id),
            'bills' => $this->getOrderBills($id),
            'returnDocs' => $this->getReturnDocs($id),
            'pipelines' => $pipelines
        ]);
    }

    public function deleteOrder($id)
    {
        try {
            $order = Order::find($id);
            OrderArchive::create($order->toArray());
            $order->delete();
            return redirect()->back()->with(['Msg' => 'Order deleted successfully!']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['Err' => $th->getMessage()]);
        }
    }

    protected function allowedExtensions()
    {
        return ['xlsx', 'xls', 'pdf', 'docs', 'doc', 'docx', 'csv', 'odt', 'jpg', 'jpeg', 'png'];
    }

    protected function createSlug($title, $separator = '-', $language = 'en')
    {
        $flip = $separator == '-' ? '_' : '-';
        $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);
        $title = str_replace('@', $separator . 'at' . $separator, $title);
        $title = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', $title);
        $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);
        return mb_strtolower(trim($title, $separator));
    }

    protected function getOrderAssignee($order)
    {
        if (!$this->is_assigned($order)) {
            return null;
        }
        $data = OrderAssignment::where('order', $order)->first();
        $admin = $data->admin;
        return User::find($admin);
    }
    protected function is_assigned($order)
    {
        return OrderAssignment::where('order', $order)->count() > 0;
    }
    protected function getOrders($pipeline)
    {
        $data = Order::where('progress', $pipeline)->orderBy('id', 'desc')->get();
        if (is_object($data)) {
            return $data->toArray();
        }
        return [];
    }
    protected function getOrderBills($order)
    {
        $data = Bill::where('order', $order)->get();
        if (is_object($data)) {
            return $data->toArray();
        }
        return [];
    }
    protected function getReturnDocs($order)
    {
        $data = OrderDocument::where('order', $order)->get();
        if (is_object($data)) {
            return $data->toArray();
        }
        return [];
    }
    protected function getUsers($case = 1)
    {
        switch ($case) {
            case 1:
                $data = User::where('admin', true)->get();
                if (is_object($data)) {
                    return $data->toArray();
                }
                break;
            case 2:
                $data = User::where('admin', true)->where('enabled', true)->get();
                if (is_object($data)) {
                    return $data->toArray();
                }
                break;
            case 3:
                $data = User::where('admin', true)->where('enabled', false)->get();
                if (is_object($data)) {
                    return $data->toArray();
                }
                break;
        }
        return [];
    }
}
