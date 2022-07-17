<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;

class CustomPasswordController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $data = $request->all();
        $password = Hash::make($data['password']);
        User::where('email', $request->get('email'))->update(['password' => $password]);
        return redirect($this->redirectTo);
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
