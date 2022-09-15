<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\ServiceGroupsController;
use App\Http\Controllers\User\ServiceFormController;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceGroup;
use Illuminate\Support\Str;
use Storage;
use Validator;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function services()
    {
        $serviceGroup = new ServiceGroupsController();
        return view('user.services', [
            'groups' => $serviceGroup->getServiceGroups(),
            'all' => $this->getServices(),
            'active' => $this->getServices(2),
            'inactive' => $this->getServices(3)
        ]);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'deposit' => 'required|integer',
            'price' => 'required|integer',
            'type' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with(['Err' => 'Invalid input fields']);
        }
        $input = $request->all();
        if (!$request->hasfile('artwork')) {
            return redirect()->back()->withInput()->with(['Err' => 'Invalid artwork. Must be an image',]);
        }
        $artwork = $request->file('artwork');
        $extension = $artwork->getClientOriginalExtension();
        $file_name = (string)Str::uuid() . '.' . $extension;
        Storage::disk('custom')->putFileAs('services', $artwork, $file_name);
        $file_path = config('app.url') . 'artwork/services/' . $file_name;
        $group_meta = ServiceGroup::find($input['type']);
        $input['type_name'] = $group_meta->name;
        $input['artwork'] = $file_path;
        $input['name'] = trim(ucwords(strtolower($input['name'])));
        Service::create($input);
        return redirect()->back()->with(['Msg' => 'Service created']);
    }

    public function view($id)
    {
        $serviceGroup = new ServiceGroupsController();
        $forms = new ServiceFormController();
        return view('user.edit_service', [
            'service' => Service::find($id),
            'groups' => $serviceGroup->getServiceGroups(),
            'forms' => $forms->getServiceFields($id),
            'booleans' => [
                0 => 'No',
                1 => 'Yes'
            ]
        ]);
    }

    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'deposit' => 'required|integer',
            'price' => 'required|integer',
            'type' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with(['Err' => 'Invalid input fields']);
        }
        $input = $request->all();
        if ($request->hasfile('artwork')) {
            $artwork = $request->file('artwork');
            $extension = $artwork->getClientOriginalExtension();
            $file_name = (string)Str::uuid() . '.' . $extension;
            Storage::disk('custom')->putFileAs('services', $artwork, $file_name);
            $file_path = config('app.url') . 'artwork/services/' . $file_name;
            $input['artwork'] = $file_path;
        }
        $group_meta = ServiceGroup::find($input['type']);
        $input['type_name'] = $group_meta->name;
        $input['name'] = trim($input['name']);
        Service::find($id)->update($input);
        return redirect()->back()->with(['Msg' => 'Service created']);
    }

    public function enable($id)
    {
        Service::find($id)->update(['enabled' => 1]);
        return redirect()->back()->with(['Msg' => 'Service enabled']);
    }

    public function disable($id)
    {
        Service::find($id)->update(['enabled' => 0]);
        return redirect()->back()->with(['Msg' => 'Service disabled']);
    }

    public function drop($id)
    {
        Service::find($id)->delete();
        return redirect()->back()->with(['Msg' => 'Service deleted']);
    }

    protected function createCode($length = 5)
    {
        $characters = 'abcdefghijk';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    protected function getServices($case = 1)
    {
        switch ($case) {
            case 1:
                $data = Service::all();
                if (is_object($data)) {
                    return $data->toArray();
                }
                break;
            case 2:
                $data = Service::where('enabled', true)->get();
                if (is_object($data)) {
                    return $data->toArray();
                }
                break;
            case 3:
                $data = Service::where('enabled', false)->get();
                if (is_object($data)) {
                    return $data->toArray();
                }
                break;
        }
        return [];
    }
}
