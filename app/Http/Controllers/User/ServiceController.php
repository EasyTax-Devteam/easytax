<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Str;
use Storage;
use Validator;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function services(){
        return view('user.services', [
            'all' => $this->getServices(),
            'active' => $this->getServices(2),
            'inactive' => $this->getServices(3)
        ]);
    }

    public function add_service(Request $request ){
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:255',
            'price' => 'required|string',
            'type' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with([ 'Err' => 'Invalid input fields', ]);
        }
        $input = $request->all();
        if( !$request->hasfile('artwork') ) {
            return redirect()->back()->withInput()->with([ 'Err' => 'Invalid artwork. Must be an image', ]);
        }
        $artwork = $request->file('artwork');
        $extension = $artwork->getClientOriginalExtension();
        $file_name = (string)Str::uuid() . '.' . $extension;
        Storage::disk('custom')->putFileAs('services', $artwork, $file_name);
        $file_path = config('app.url') . 'artwork/services/' . $file_name;
        $input['artwork'] = $file_path;
        Service::create($input);
        return redirect()->back()->with([ 'Msg' => 'Service created']);
    }

    public function enable($id) {
        Service::find($id)->update(['enabled' => 1]);
        return redirect()->back()->with([ 'Msg' => 'Service enabled']);
    }

    public function disable($id) {
        Service::find($id)->update(['enabled' => 0]);
        return redirect()->back()->with([ 'Msg' => 'Service disabled']);
    }

    protected function createCode($length = 5) {
        $characters = 'abcdefghijk';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    protected function getServices($case = 1){
        switch ($case) {
            case 1:
                $data = Service::all();
                if( is_object($data) ){
                    return $data->toArray();
                }
                break;
            case 2:
                $data = Service::where('enabled', true)->get();
                if( is_object($data) ){
                    return $data->toArray();
                }
                break;
            case 3:
                $data = Service::where('enabled', false)->get();
                if( is_object($data) ){
                    return $data->toArray();
                }
                break;
        }
        return [];
    }
}
