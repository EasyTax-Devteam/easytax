<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Site;
use App\Models\User;
use Illuminate\Support\Str;
use Storage;
use Validator;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function settings()
    {
        return view('user.settings', [
            'settings' => json_decode(json_encode($this->getSettings())),
        ]);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'support_email' => 'email|required',
            'phone' => 'string|required',
            'address' => 'string|required',
            'working_hours' => 'string|required',
            'facebook' => 'string|required',
            'twitter' => 'string|required',
            'linkedin' => 'string|required',
            'instagram' => 'string|required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with(['Err' => 'Invalid input fields',]);
        }
        $input = $request->all();
        $count = Site::where('id', 1)->count();
        if ($count > 0) {
            $site = Site::find(1);
            $site->email = $input['email'];
            $site->support_email = $input['support_email'];
            $site->phone = $input['phone'];
            $site->address = $input['address'];
            $site->working_hours = $input['working_hours'];
            $site->facebook = $input['facebook'];
            $site->twitter = $input['twitter'];
            $site->linkedin = $input['linkedin'];
            $site->instagram = $input['instagram'];
            $site->save();
            return redirect()->back()->with(['Msg' => 'Settings updated']);
        }
        Site::create($input);
        return redirect()->back()->with(['Msg' => 'Settings created']);
    }

    protected function getSettings()
    {
        $site = Site::find(1);
        if (is_object($site)) {
            return $site->toArray();
        }
        return [
            'email' => null, 'support_email' => null, 'phone' => null, 'address' => null,
            'working_hours' => null, 'facebook' => null, 'twitter' => null, 'linkedin' => null, 'instagram' => null
        ];
    }
}
