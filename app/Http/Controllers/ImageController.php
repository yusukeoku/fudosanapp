<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * 画像登録画面を表示する
     */
    public function edit(Request $request): View
    {
        $images = Image::where('user_id', '$user_id')->get();
        // if(!$images){
        if ($images->isEmpty()) {
            return view('image.edit',['images' => $images]);
        }
            return view('image.update',['images' => $images]);
    }

    /**
     * 画像を登録する
     */
    public function create(ImageRequest $request)
    {
        // 現在認証しているユーザーのIDを取得
        $user_id = Auth::id();

        $image_group_id = (string) Str::uuid();
        $property_id = (string) Str::uuid();

        $image_path1 = $request->file('image1')->store('images','public');

        Image::create([
            'user_id' => $user_id,
            'image_path' => $image_path1,
            'property_id' => $property_id,
            'image_group_id' => $image_group_id,
            'jyutakusapo_check' => "0",
            'user_check' => "0"
        ]);

        $image_path2 = $request->file('image2')->store('images','public');

        Image::create([
            'user_id' => $user_id,
            'image_path' => $image_path2,
            'property_id' => $property_id,
            'image_group_id' => $image_group_id,
            'jyutakusapo_check' => "0",
            'user_check' => "0"
        ]);

        $image_path3 = $request->file('image3')->store('images','public');

        Image::create([
            'user_id' => $user_id,
            'image_path' => $image_path3,
            'property_id' => $property_id,
            'image_group_id' => $image_group_id,
            'jyutakusapo_check' => "0",
            'user_check' => "0"
        ]);

        $today = date('Y-m-d');
        $images = Image::where('created_at', 'like', "%$today%")->get();
        return view('image.update',['images' => $images]);
    }

    /**
    * 画像を更新する
    */
    public function update(ImageRequest $request)
    {
        $request->file('image')->store('public/images/');
        $images = new Image();
        $images->save();
        // $images = Image::all();
        return view('image.update',['images' => $images]);
    }
}
