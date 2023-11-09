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
        $user_id = Auth::id();
        // $images = Image::all();
        // $image_group_id = '1b016266-2c5a-4aa8-8844-1684e02e216f';
        $image_group_id = Image::latest()->first();
        // $images = Image::where('user_id',$user_id)->first();
        $images = Image::where('image_group_id',$image_group_id)->first();
        // dd($image_group_id);
        return view('image.edit',['images' => $images]);
    }

    public function create(ImageRequest $request)
    {
    // 現在認証しているユーザーのIDを取得
    $user_id = Auth::id();

    $image_group_id = (string) Str::uuid();
    $property_id = (string) Str::uuid();

    // dd($image_group_id);

        // $image_path1 = $request->file('image1')->store('images', 'public');
        // $image_path2 = $request->file('image2')->store('images', 'public');
        // $image_path3 = $request->file('image3')->store('images', 'public');

        if ($request->hasFile('image1')) {
            $image_path1 = $request->file('image1')->store('images', 'public');
        } else {
            $image_path1 = null;
        }

        if ($request->hasFile('image2')) {
            $image_path2 = $request->file('image2')->store('images', 'public');
        } else {
            $image_path2 = null;
        }

        if ($request->hasFile('image3')) {
            $image_path3 = $request->file('image3')->store('images', 'public');
        } else {
            $image_path3 = null;
        }

        // dd($image_path1);

        Image::create([
            'user_id' => $user_id,
            'image_path_1' => $image_path1,
            // 'image_path_1' => 'images/Ah4NGduuchLrxwctndF7mPjETF1zmxotL0b2iPLB.jpg',
            'image_path_2' => $image_path2,
            'image_path_3' => $image_path3,
            'property_id' => $property_id,
            'image_group_id' => $image_group_id,
            'agent_check' => "0",
            'tenant_check' => "0",
            'owner_check' => "0",
            'image_order' => 1, // 画像の順序を設定
        ]);

        $images = Image::where('user_id',$user_id)->first();

        // dd($images);
        return view('image.edit', ['images' => $images]);
    }

    //物件写真を更新する
    public function update(Request $request)
    {
        // 現在認証しているユーザーのIDを取得
        $user_id = Auth::id();
        $image_group_id = $request->image_group_id;

        // dd($image_group_id);

        //ファイルが送信されたか確認
        if($request->hasFile('image1')){//バリデーションでチェックするなら、ここは無くてもいいかも
        //アップロードに成功しているか確認
           if($request->file('image1')->isValid()){
                //storeを行うならここまで来ないとだめだと思います
                $image_path1 = $request->file('image1')->store('images','public');
                Image::where('image_group_id',$request->image_group_id)->update([
                    'image_path_1' => $image_path1,
                ]);
            }
        }

        // dd($request->file('image1'));

        //ファイルが送信されたか確認
        if($request->hasFile('image2')){//バリデーションでチェックするなら、ここは無くてもいいかも
        //アップロードに成功しているか確認
            if($request->file('image2')->isValid()){
                    $image_path2 = $request->file('image2')->store('images','public');
                    Image::where('image_group_id',$request->image_group_id)->update([
                    'image_path_2' => $image_path2,
                ]);
            }
        }

        //ファイルが送信されたか確認
        if($request->hasFile('image3')){//バリデーションでチェックするなら、ここは無くてもいいかも
            //アップロードに成功しているか確認
               if($request->file('image3')->isValid()){
                    $image_path3 = $request->file('image3')->store('images','public');
                    Image::where('image_group_id',$request->image_group_id)->update([
                    'image_path_3' => $image_path3,
                ]);
            }
        }

        // Image::where('image_group_id',$request->image_group_id)->update([
        //     'image_path_1' => $image_path1,
        //     'image_path_2' => $image_path2,
        //     'image_path_3' => $image_path3,
        // ]);

        $images = Image::where('image_group_id',$request->image_group_id)->first();
        return view('image.edit',['images' => $images]);
    }

    public function check(Request $request)
    {
        $user_id = Auth::id();

        $agent_check = 0;
        if($request->check=="on"){
            $agent_check = 1;
        }

        // dd($request->check);
        Image::where('image_group_id',$request->image_group_id)->update(['agent_check' => $agent_check]);

        $images = Image::where('image_group_id',$request->image_group_id)->first();

        // dd($images);

        // dd($request->image_group_id);

        // $images = Image::all();

        // それぞれの画像レコードをアップデート
        // $images->each(function ($image) {
        //     $image->update([
        //         'agent_check' => 1,
        // //     ]);
        // });
        return view('image.edit',['images' => $images]);
    }
}
