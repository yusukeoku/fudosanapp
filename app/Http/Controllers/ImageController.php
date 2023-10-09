<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\Image;
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
    /**
     * 画像登録画面を表示する
     */
    public function edit(Request $request): View
    {
        $users = Auth::user();  // ユーザIDを取得
        $uploadCount = $users->upload_count; //upload_count変数設定
        // dd($uploadCount);

        //画像投稿回数upload_countが0の時はedit画面を表示
        if($uploadCount == 0){
            $images = []; //imagesに何もない状態にして
            return view('image.edit',['images' => $images]); //image.edit画面へ飛ぶ
        }
        //画像投稿回数upload_countが0でない時はupdate画面を表示
        else{
            $images = Image::all(); //imageに今までの情報全部入れて
            return view('image.update',['images' => $images]); //image.updateに飛ぶ
        }
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

        //image_countを+1する
        $user = Auth::user();
        $user -> increment('upload_count');

        $today = date('Y-m-d');
        $images = Image::where('created_at', 'like', "%$today%")->get();
        return view('image.update',['images' => $images]);
    }

    /**
    * 画像を更新する
    */
    public function update(ImageRequest $request)
    {
        // 今表示されている画像を削除して、新たな画像を登録する
        $image_path1 = Image()->$image_path1;
        $image_path2 = Image::image();
        $image_path3 = Image::image();
        Storage::disk('public')->delete('images/'.$item->image);
        Storage::disk('images')->delete($image_path2);
        Storage::disk('images')->delete($image_path3);

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

        //image_countを+1する
        $user = Auth::user();
        $user -> increment('upload_count');

        $today = date('Y-m-d');
        $images = Image::where('created_at', 'like', "%$today%")->get();
        return view('image.update',['images' => $images]);
    }
}
