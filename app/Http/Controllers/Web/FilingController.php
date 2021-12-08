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
use Storage;
use App\Http\Controllers\Web\MpesaController;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerWelcome;
use App\Mail\CustomerPayment;
use App\Mail\AdminPayment;

class FilingController extends Controller
{
    public function file_return($id){
        if( intval($id) > 0 ){
            $service = Service::find($id);
            Session::put('active_service', $service);
            switch ( $service->type ) {
                case 'isNill':
                    return redirect()->route('w.f.nill');
                    break;

                case 'isFreelance':
                    return redirect()->route('w.f.freelance');
                    break;
                
                case 'isEmployee':
                    return redirect()->route('w.f.employee');
                    break;

                case 'isCompany':
                    return redirect()->route('w.f.company');
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
            $existsUser = $this->existsUser(trim($input['kraPin']));
            if( $existsUser ){
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
            if( !$existsUser ){
                $mail_data = [ 'name' => $input['firstName'], 'pin' => $input['kraPin'] ];
                Mail::to($input['emailAddress'])->send(new CustomerWelcome($mail_data));
            }
            DB::commit();
            return redirect()->route('w.f.payform');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['Err' => $th->getMessage()]);
        }
    }

    public function file_Freelance(){
        $service = Session::get('active_service');
        if(!$service){
            return redirect()->route('w.f.return', ['id' => 0]);
        }
        return view('checkout.freelance', [
            'service' => $service,
        ]);
    }

    public function post_Freelance(Request $request){
        $validator = Validator::make($request->all(), [ 
            'service' => 'required|string',
            'kraPin' => 'required|string|min:11|max:12|regex:/^[A-Z]{1}/|regex:/^[A-Z0-9]{10}[A-Z]$/',
            'itaxPassword' => 'required|string',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'phoneNumber' => 'required|string',
            'emailAddress' => 'required|email',
            'year' => 'required|string',
            'paying_kenyan_insurance_policies' => 'required|string',
            'paid_mortgage_for_tax_year' => 'required|string',
            'kenyan_insurance_policies_paid' => 'required_if:paying_kenyan_insurance_policies,=,Yes'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        if( !$request->hasfile('income_and_expenses_schedule') ) {
            return redirect()->back()->withInput()->with(['Err' => 'You must upload a valid xlsx file for Income & expenses schedule']);
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
            $existsUser = $this->existsUser(trim($input['kraPin']));
            if( $existsUser ){
                $customer = $this->getExistingUser(trim($input['kraPin']));
                $customerId = $customer->id;
            }else{
                $customerId = Customer::create($newCustomer)->id;
            }
            $newOrder = [
                'customer' => $customerId,
                'pin' => $input['kraPin'],
                'itax_password' => $input['itaxPassword'],
                'has_taxable_income' => 'Yes',
                'paying_kenyan_insurance_policies' => $input['paying_kenyan_insurance_policies'],
                'kenyan_insurance_policies_paid' => implode(',', $input['kenyan_insurance_policies_paid']),
                'paid_mortgage_for_tax_year' => $input['paid_mortgage_for_tax_year'],
                'service' => $input['service']
            ];
            /** upload ic schedule */
            $income_and_expenses_schedule = $request->file('income_and_expenses_schedule');
            $extension = $income_and_expenses_schedule->getClientOriginalExtension();
            if( !in_array(strtolower($extension), ['xlsx', 'xls']) ){
                return redirect()->back()->withInput()->with(['Err' => 'Error. Only excel files allowed for Income & expenses schedule']);
            }
            $file_name = strtolower($input['kraPin']) . '-income-expense-sch-' . time() . '.' . $extension;
            Storage::disk('local')->putFileAs('customers', $income_and_expenses_schedule, $file_name);
            $newOrder['income_and_expenses_schedule'] = $file_name;
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
            if( !$existsUser ){
                $mail_data = [ 'name' => $input['firstName'], 'pin' => $input['kraPin'] ];
                Mail::to($input['emailAddress'])->send(new CustomerWelcome($mail_data));
            }
            DB::commit();
            return redirect()->route('w.f.payform');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['Err' => $th->getMessage()]);
        }
    }

    public function file_Employee(){
        $service = Session::get('active_service');
        if(!$service){
            return redirect()->route('w.f.return', ['id' => 0]);
        }
        return view('checkout.employee', [
            'service' => $service,
        ]);
    }

    public function post_Employee(Request $request){
        $validator = Validator::make($request->all(), [ 
            'service' => 'required|string',
            'kraPin' => 'required|string|min:11|max:12|regex:/^[A-Z]{1}/|regex:/^[A-Z0-9]{10}[A-Z]$/',
            'itaxPassword' => 'required|string',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'phoneNumber' => 'required|string',
            'emailAddress' => 'required|email',
            'year' => 'required|string',
            'paying_kenyan_insurance_policies' => 'required|string',
            'paid_mortgage_for_tax_year' => 'required|string',
            'kenyan_insurance_policies_paid' => 'required_if:paying_kenyan_insurance_policies,=,Yes'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        if( !$request->hasfile('p_nine_form') ) {
            return redirect()->back()->withInput()->with(['Err' => 'You must upload a valid file for P9 form']);
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
            $existsUser = $this->existsUser(trim($input['kraPin']));
            if( $existsUser ){
                $customer = $this->getExistingUser(trim($input['kraPin']));
                $customerId = $customer->id;
            }else{
                $customerId = Customer::create($newCustomer)->id;
            }
            $newOrder = [
                'customer' => $customerId,
                'pin' => $input['kraPin'],
                'itax_password' => $input['itaxPassword'],
                'has_taxable_income' => 'Yes',
                'paying_kenyan_insurance_policies' => $input['paying_kenyan_insurance_policies'],
                'kenyan_insurance_policies_paid' => implode(',', $input['kenyan_insurance_policies_paid']),
                'paid_mortgage_for_tax_year' => $input['paid_mortgage_for_tax_year'],
                'service' => $input['service']
            ];
            /** upload ic schedule */
            $p_nine_form = $request->file('p_nine_form');
            $extension = $p_nine_form->getClientOriginalExtension();
            if( !in_array(strtolower($extension), ['xlsx', 'xls', 'pdf', 'docs', 'doc', 'docx', 'csv', 'odt']) ){
                return redirect()->back()->withInput()->with(['Err' => 'Error. Onlyvalid files allowed for P9 form']);
            }
            $file_name = strtolower($input['kraPin']) . '-p-nine-form-' . time() . '.' . $extension;
            Storage::disk('local')->putFileAs('customers', $p_nine_form, $file_name);
            $newOrder['p_nine_form'] = $file_name;
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
            if( !$existsUser ){
                $mail_data = [ 'name' => $input['firstName'], 'pin' => $input['kraPin'] ];
                Mail::to($input['emailAddress'])->send(new CustomerWelcome($mail_data));
            }
            DB::commit();
            return redirect()->route('w.f.payform');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['Err' => $th->getMessage()]);
        }
    }


    public function file_Company(){
        $service = Session::get('active_service');
        if(!$service){
            return redirect()->route('w.f.return', ['id' => 0]);
        }
        return view('checkout.company', [
            'service' => $service,
        ]);
    }

    public function post_Company(Request $request){
        $validator = Validator::make($request->all(), [ 
            'service' => 'required|string',
            'kraPin' => 'required|string|min:11|max:12|regex:/^[A-Z]{1}/|regex:/^[A-Z0-9]{10}[A-Z]$/',
            'itaxPassword' => 'required|string',
            'firstName' => 'required|string',
            'phoneNumber' => 'required|string',
            'emailAddress' => 'required|email',
            'year' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        if( !$request->hasfile('financial_statements') ) {
            return redirect()->back()->withInput()->with(['Err' => 'You must upload valid files for statements']);
        }
        $input = $request->all();
        DB::beginTransaction();
        try {
            $newCustomer = [
                'email' => $input['emailAddress'],
                'pin' => $input['kraPin'],
                'phone' => $input['phoneNumber'],
                'fname' => $input['firstName'],
                'lname' => 'inc.',
                'itax_password' => $input['itaxPassword'],
                'service' => $input['service']
            ];
            $customerId = null;
            $existsUser = $this->existsUser(trim($input['kraPin']));
            if( $existsUser ){
                $customer = $this->getExistingUser(trim($input['kraPin']));
                $customerId = $customer->id;
            }else{
                $customerId = Customer::create($newCustomer)->id;
            }
            $newOrder = [
                'customer' => $customerId,
                'pin' => $input['kraPin'],
                'itax_password' => $input['itaxPassword'],
                'has_taxable_income' => 'Yes',
                'service' => $input['service']
            ];
            /** upload ic schedule */
            $financial_statements = $request->file('financial_statements');
            $paths = [];
            foreach($financial_statements as $key => $financial_statement ):
                $extension = $financial_statement->getClientOriginalExtension();
                if( !in_array(strtolower($extension), ['xlsx', 'xls', 'pdf', 'docs', 'doc', 'docx', 'csv', 'odt']) ){
                    return redirect()->back()->withInput()->with(['Err' => 'Error. Only valid files allowed for statements']);
                }
                $file_name = strtolower($input['kraPin']) . '-f-stmt-'. $key . '-' . time() . '.' . $extension;
                Storage::disk('local')->putFileAs('customers', $financial_statement, $file_name);
                array_push($paths, $file_name);
            endforeach;
            $newOrder['financial_statements'] = implode(',', $paths);
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
            if( !$existsUser ){
                $mail_data = [ 'name' => $input['firstName'], 'pin' => $input['kraPin'] ];
                Mail::to($input['emailAddress'])->send(new CustomerWelcome($mail_data));
            }
            DB::commit();
            return redirect()->route('w.f.payform');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['Err' => $th->getMessage()]);
        }
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
