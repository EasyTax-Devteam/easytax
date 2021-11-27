<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Str;
use Storage;
use Validator;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function payments(){
        return view('user.payments', [
            'all' => $this->getPayments(),
            'active' => $this->getPayments(2),
            'inactive' => $this->getPayments(3)
        ]);
    }
    protected function getPayments($case = 1){
        switch ($case) {
            case 1:
                $data = Payment::all();
                if( is_object($data) ){
                    return $data->toArray();
                }
                break;
            case 2:
                $data = Payment::where('is_paid', true)->get();
                if( is_object($data) ){
                    return $data->toArray();
                }
                break;
            case 3:
                $data = Payment::where('is_paid', false)->get();
                if( is_object($data) ){
                    return $data->toArray();
                }
                break;
        }
        return [];
    }
}
