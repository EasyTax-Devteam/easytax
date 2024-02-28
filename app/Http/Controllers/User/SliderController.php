<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrderingField;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function setOrdering(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'ordering_col' => 'required|string',
                'ordering_dir' => 'required|string',
                'target' => 'required|string',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with(['Err' => 'Invalid input fields' . json_encode($validator->errors())]);
            }
            $input = $request->all();
            OrderingField::where('target', $input['target'])->update([
                'ordering_col' => $input['ordering_col'],
                'ordering_dir' => $input['ordering_dir'],
            ]);
            return redirect()->back()->with(['Msg' => 'Items ordering fields updated']);
        } catch (\Throwable $th) {
            abort(403, $th->getMessage());
        }
    }

    public function sliders()
    {
        return view('user.sliders', [
            'all' => $this->getSliders(),
        ]);
    }

    public function add_slider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prefix' => 'required|string|max:55',
            'title' => 'required|string',
            'description' => 'required|string',
            'url' => 'required|string',
            'button_text' => 'required|string',
            'order' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with(['Err' => 'Invalid  input fields',]);
        }
        $input = $request->all();
        $input['slug'] = $this->str_slug($input['prefix'] . ' ' . $input['title']);
        if (!$request->hasfile('image')) {
            return redirect()->back()->withInput()->with(['Err' => 'Invalid image. Must be an image',]);
        }

        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $file_name = $input['slug'] . '.' . $extension;
        Storage::disk('custom')->putFileAs('services', $image, $file_name);
        $file_path = config('app.url') . 'artwork/services/' . $file_name;
        $input['image'] = $file_path;

        Slider::create($input);
        return redirect()->back()->with(['Msg' => 'Slider created']);
    }

    public function slider($id)
    {
        return view('user.single-slider', [
            'slider' => Slider::find($id),
        ]);
    }

    public function edit_slider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|max:10',
            'prefix' => 'required|string|max:55',
            'title' => 'required|string',
            'description' => 'required|string',
            'url' => 'required|string',
            'button_text' => 'required|string',
            'order' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with(['Err' => 'Invalid  input fields',]);
        }
        $input = $request->all();
        $slug = $this->str_slug($input['prefix'] . ' ' . $input['title']);
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $file_name = $slug . '.' . $extension;
            Storage::disk('custom')->putFileAs('services', $image, $file_name);
            $file_path = config('app.url') . 'artwork/services/' . $file_name;
            $input['image'] = $file_path;
        }

        Slider::find($input['id'])->update($input);
        return redirect()->back()->with(['Msg' => 'Slider updated']);
    }


    public function delete_slider($id)
    {
        Slider::find($id)->delete();
        return redirect()->back()->with(['Msg' => 'Slider deleted!']);
        
    }

    protected function str_slug($title, $separator = '-', $language = 'en')
    {
        $flip = $separator == '-' ? '_' : '-';
        $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);
        $title = str_replace('@', $separator . 'at' . $separator, $title);
        $title = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', $title);
        $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);
        return mb_strtolower(trim($title, $separator));
    }

    protected function getSliders(){
        $order = OrderingField::getOrdering();
        $sliders = Slider::orderBy($order->ordering_col, $order->ordering_dir)
            ->get();
        return $sliders;
    }

}
