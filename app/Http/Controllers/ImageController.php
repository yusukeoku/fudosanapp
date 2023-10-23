<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // 物件写真編集画面を表示する
    public function edit(Request $request): View
    {
        $images = Image::all();
        return view('image.edit',['images' => $images]);
    }

    //物件写真を登録、更新する
    public function update(ImageRequest $request)
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
            'agent_check' => "0",
            'tenant_check' => "0",
            'owner_check' => "0",
        ]);

        $image_path2 = $request->file('image2')->store('images','public');

        Image::create([
            'user_id' => $user_id,
            'image_path' => $image_path2,
            'property_id' => $property_id,
            'image_group_id' => $image_group_id,
            'agent_check' => "0",
            'tenant_check' => "0",
            'owner_check' => "0",
            ]);

        $image_path3 = $request->file('image3')->store('images','public');

        Image::create([
            'user_id' => $user_id,
            'image_path' => $image_path3,
            'property_id' => $property_id,
            'image_group_id' => $image_group_id,
            'agent_check' => "0",
            'tenant_check' => "0",
            'owner_check' => "0",
            ]);

        $today = date('Y-m-d');
        $images = Image::where('created_at', 'like', "%$today%")->get();
        return view('image.edit',['images' => $images]);
    }

    public function check(ImageRequest $request)
    {
        $images = Image::all();
        // それぞれの画像レコードをアップデート
        $images->each(function ($image) {
            $image->update([
                'agent_check' => 1,
            ]);
        });
        return view('image.edit',['images' => $images]);
    }
}
