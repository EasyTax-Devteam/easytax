<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrderAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewAccount;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orders(){
        return view('user.orders');
    }

    public function order($id){
        return view('user.order_details', [
            'assigned' => $this->is_assigned($id),
            'user' => $this->getOrderAssignee($id),
            'admins' => $this->getUsers(2)
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
