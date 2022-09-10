<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\ServiceForm;
use Validator;

class ServiceFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service' => 'required|string|max:20',
            'field_label' => 'required|string|max:255',
            'field_is_required' => 'boolean',
            'field_name' => 'required|string|max:255',
            'field_placeholder' => 'required|string|max:255',
            'field_type' => 'required|string|max:255',
            'field_is_multiple' => 'required|boolean',
            'field_max_uploads' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with(['Err' => 'Invalid input fields',]);
        }
        $input = $this->clean_fields($request->all());
        $input['validation_rule'] = $request->get('validation_rule');
        $input['field_id'] = $input['field_name'] . '_id';
        $input['field_default_value'] = null;
        ServiceForm::create($input);
        return redirect()->back()->with(['Msg' => 'Service Form created']);
    }

    public function view($id)
    {
        $form = ServiceForm::find($id);
        return view('user.edit_form', [
            'service' => Service::find($form->service),
            'form' => $form,
            'booleans' => [
                0 => 'No',
                1 => 'Yes'
            ]
        ]);
    }

    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'field_label' => 'required|string|max:255',
            'field_is_required' => 'boolean',
            'field_name' => 'required|string|max:255',
            'field_placeholder' => 'required|string|max:255',
            'field_type' => 'required|string|max:255',
            'field_is_multiple' => 'required|boolean',
            'field_max_uploads' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with(['Err' => 'Invalid input fields',]);
        }
        $input = $this->clean_fields($request->all());
        $input['validation_rule'] = $request->get('validation_rule');
        $input['field_id'] = $input['field_name'] . '_id';
        $input['field_default_value'] = null;
        ServiceForm::find($id)->update($input);
        return redirect()->back()->with(['Msg' => 'Service Form updated']);
    }
    public function getServiceFields($service)
    {
        $data = ServiceForm::where('service', $service)->get();
        $data->sort();
        if (is_object($data)) {
            return $data->toArray();
        }
        return [];
    }

    public function drop($id)
    {
        ServiceForm::find($id)->delete();
        return redirect()->back()->with(['Msg' => 'Service Form Field deleted']);
    }

    protected function clean_fields($fields)
    {
        $cleaned = [];
        foreach ($fields as $key => $value) :
            $cleaned[$key] = trim(strtolower($value));
        endforeach;

        return $cleaned;
    }
}
