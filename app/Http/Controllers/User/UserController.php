<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewAccount;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderAssignment;
use App\Models\OrderDocument;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->admin == 1) {
            $inProgress = $this->getMyOrders('in_progress');
            $inReview = $this->getMyOrders('in_review');
            $approved = $this->getMyOrders('complete');
            return view('user.index', [
                'inProgress' => $inProgress,
                'inReview' => $inReview,
                'approved' => $approved
            ]);
        }
        return view('user.index', [
            'data' => $this->dashboards(),
            'ordersGraph' => $this->getOrdersGraphData(),
            'revenueGraph' => $this->getRevenueGraphData()
        ]);
    }
    protected function getOrdersGraphData()
    {
        $lastSix = User::lastSixMonths();
        $labels = $data = [];
        foreach (array_reverse($lastSix) as $date => $month) :
            $ordersCount =  Order::where('created_at', 'like', '%' . $date . '%')->count();
            array_push($labels, $month);
            array_push($data, $ordersCount);
        endforeach;
        return [
            'label' => $labels,
            'data' => $data
        ];
    }
    protected function getRevenueGraphData()
    {
        $lastSix = User::lastSixMonths();
        $labels = $data = [];
        foreach (array_reverse($lastSix) as $date => $month) :
            $revenue =  Payment::where('is_paid', true)->where('created_at', 'like', '%' . $date . '%')->sum('amount');
            array_push($labels, $month);
            array_push($data, $revenue);
        endforeach;
        return [
            'label' => $labels,
            'data' => $data
        ];
    }
    protected function getMyOrders($pipeline)
    {
        $idList = $this->getMyOrdersIds();
        $data = Order::whereIn('id', $idList)->where('progress', $pipeline)->orderBy('id', 'desc')->get();
        if (is_object($data)) {
            return $data->toArray();
        }
        return [];
    }

    protected function getMyOrdersIds()
    {
        $data = OrderAssignment::select('order')->where('admin', Auth::user()->id)->get();
        if (is_object($data)) {
            return $data->toArray();
        }
        return [];
    }

    public function users()
    {
        return view('user.users', [
            'all' => $this->getUsers(),
            'active' => $this->getUsers(2),
            'inactive' => $this->getUsers(3)
        ]);
    }

    public function add_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with(['Err' => 'Invalid  input fields',]);
        }
        $input = $request->all();
        $recipient = $input['email'];
        $input['defaultPassword'] = $input['password'];
        $input['password'] = Hash::make($input['password']);
        $input['root'] = 0;
        $input['admin'] = 1;
        User::create($input);
        Mail::to($recipient)->send(new NewAccount($input));
        return redirect()->back()->with(['Msg' => 'Account created. User notified']);
    }

    public function enable_user($id)
    {
        User::find($id)->update(['enabled' => 1]);
        return redirect()->back()->with(['Msg' => 'Account enabled']);
    }

    public function disable_user($id)
    {
        User::find($id)->update(['enabled' => 0]);
        return redirect()->back()->with(['Msg' => 'Account disabled']);
    }


    public function delete_user($id)
    {
        $hasAssignments = OrderAssignment::where('admin', $id)->count() > 0;
        if($hasAssignments){
            $user = User::find($id);
            return redirect()->back()->with(['Err' => 'Could not delete user '.$user->name.'. The user has active order assignments',]);
        }
        // $hasDocuments = OrderDocument::where('uploaded_by', $id)->count() > 0;
        // if($hasDocuments){
        //     return redirect()->back()->with(['Err' => 'Could not delete user. The user has active customer files',]);
        // }
        User::find($id)->delete();
        return redirect()->back()->with(['Msg' => 'User account deleted!']);
        
    }

    public function exit()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function stream($file)
    {
        try {
            $filename = ('app/customers/' . $file);
            return response()->download(storage_path($filename), null, [], null);
        } catch (\Throwable $th) {
            return abort(404, 'Error. File not found on server');
        }
    }

    protected function dashboards()
    {
        $sales = Payment::where('is_paid', true)->sum('amount');
        $customers = Customer::where('id', '>', 0)->count();
        $services = Service::where('id', '>', 0)->count();
        $orders = Order::all()->count();
        return [
            'sales' => $sales,
            'customers' => $customers,
            'services' => $services,
            'orders' => $orders
        ];
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
