<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceGroup;
use Illuminate\Support\Str;
use Storage;
use Validator;

class ServiceGroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with(['Err' => 'Invalid input fields' . json_encode($validator->errors()),]);
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
        $input['artwork'] = $file_path;
        $input['name'] = trim(ucwords(strtolower($input['name'])));
        ServiceGroup::create($input);
        return redirect()->back()->with(['Msg' => 'Service Group created']);
    }

    public function view($id)
    {
        return view('user.edit_group', [
            'service' => ServiceGroup::find($id),
        ]);
    }

    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with(['Err' => 'Invalid input fields',]);
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
        $input['name'] = trim(ucwords(strtolower($input['name'])));
        ServiceGroup::find($id)->update($input);
        return redirect()->back()->with(['Msg' => 'Service Group updated']);
    }

    public function enable($id)
    {
        ServiceGroup::find($id)->update(['enabled' => 1]);
        return redirect()->back()->with(['Msg' => 'Service Group enabled']);
    }

    public function disable($id)
    {
        ServiceGroup::find($id)->update(['enabled' => 0]);
        return redirect()->back()->with(['Msg' => 'Service Group disabled']);
    }

    public function getServiceGroups($case = 1)
    {
        switch ($case) {
            case 1:
                $data = ServiceGroup::orderBy('order')->get();
                if (is_object($data)) {
                    return $data->toArray();
                }
                break;
            case 2:
                $data = ServiceGroup::where('enabled', true)->orderBy('order')->get();
                if (is_object($data)) {
                    return $data->toArray();
                }
                break;
            case 3:
                $data = ServiceGroup::where('enabled', false)->orderBy('order')->get();
                if (is_object($data)) {
                    return $data->toArray();
                }
                break;
        }
        return [];
    }
}
