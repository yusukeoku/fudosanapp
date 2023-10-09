<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\SokoRequest;
use App\Models\Prefecture;
use App\Models\Soko;
use App\Enums\UserKubun;
use App\Libs\{
    Session,
    Utility,
    Log
};

class SokoController extends Controller
{
    /**
     * 一覧画面
     *
     * @route GET /sokos
     * @see routes/master/sokos.php
     * @param Request $request
     * @return void
     */
    public function list(Request $request)
    {
        try
        {
            // クリアボタンが押された場合
            if($request->has('clear'))
            {
                // 倉庫一覧画面にリダイレクト
                return redirect()->route('sokos');
            }

            // セッションを全てリセット
            Session::resetAll();

            // 検索用の変数を初期化
            $prefectures_id = -1;
            $soko_name = null;

            // 都道府県を取得
            $prefectures = Prefecture::all();

            // 倉庫一覧取得用のクエリを作成
            $query = Soko::query();
            $params = [];

            // 2023/10/08 奥追記ここから
            // ログイン中のユーザの区分で一覧表示する内容を変更する
            $login_user = Auth::user();  // ログインユーザ
            $user_kubun = $login_user->user_kubun;  // ユーザ区分

            // システム管理者でなければ
            if($user_kubun != UserKubun::SYSTEM_MANAGER)
            {
                // 自分の会社の基幹システムIDと同じ倉庫で絞り込み
                $system_id = $login_user->kaisha->system_id;  // 基幹システムID
                $query = $query->where('system_id', $system_id);
                $params['system_id'] = $system_id;
            }
            // 2023/10/08 奥追記ここまで

            // 都道府県が選択されている場合
            if($request->filled('prefectures_id'))
            {
                // 都道府県で絞り込み
                $prefectures_id = $request->input('prefectures_id');
                $query = $query->where('prefectures_id', $prefectures_id);
                $params['prefectures_id'] = $prefectures_id;
            }

            // 倉庫名称が入力されている場合
            if($request->filled('soko_name'))
            {
                // 倉庫名称で絞り込み
                $soko_name = $request->input('soko_name');
                $query = $query->where('soko_name', 'like', "%{$soko_name}%");
                $params['soko_name'] = $soko_name;
            }

            // 倉庫名を取得
            $sokos = $query->with('prefecture')->paginate(config('const.PER_PAGE'))->appends($params);

            // 出荷先の数を取得
            $total = $sokos->total();

            $data = [
                'prefectures_id' => $prefectures_id,
                'prefectures' => $prefectures,
                'soko_name' => $soko_name,
                'total' => $total,
                'sokos' => $sokos,
            ];
            return view('sokos.list', $data);
        }
        catch(\Exception $e)
        {
            Utility::error($request, $e);
        }
    }

    /**
     * 詳細画面
     *
     * @route GET /sokos/detail/{soko_id}
     * @see routes/master/sokos.php
     * @param Request $request
     * @return void
     */
    public function detail(Request $request)
    {
        try
        {
            // トークンを生成
            $token = Session::generateToken();

            $soko_id = $request->soko_id;
            $prefectures = Prefecture::all();

            if(Session::pull('confirm', false))
            {
                // セッションから値を取得
                $mishiyo_flag = 0;
                $soko_name = Session::get('soko_name', '');
                $soko_ryaku_name = Session::get('soko_ryaku_name', '');
                $prefectures_id = Session::get('prefectures_id', 40);
                $zip_code_1 = Session::get('zip_code_1', '');
                $zip_code_2 = Session::get('zip_code_2', '');
                $address_1 = Session::get('address_1', '');
                $address_2 = Session::get('address_2', '');
                $email = Session::get('email', '');
                $tel_no = Session::get('tel_no', '');
                $fax_no = Session::get('fax_no', '');
            }
            else
            {
                $soko = Soko::with('prefecture')->find($soko_id);
                $mishiyo_flag = $soko->mishiyo_flag;
                $soko_name = $soko->soko_name;
                $soko_ryaku_name = $soko->soko_ryaku_name;
                $prefectures_id = $soko->prefectures_id;
                $zip_code_1 = $soko->zip_code_1;
                $zip_code_2 = $soko->zip_code_2;
                $address_1 = $soko->address_1;
                $address_2 = $soko->address_2;
                $email = $soko->email;
                $tel_no = $soko->tel_no;
                $fax_no = $soko->fax_no;
            }

            $data = [
                'prefectures' => $prefectures,
                'soko_id' => $soko_id,
                'mishiyo_flag' => $mishiyo_flag,
                'soko_name' => $soko_name,
                'soko_ryaku_name' => $soko_ryaku_name,
                'prefectures_id' => $prefectures_id,
                'zip_code_1' => $zip_code_1,
                'zip_code_2' => $zip_code_2,
                'address_1' => $address_1,
                'address_2' => $address_2,
                'email' => $email,
                'tel_no' => $tel_no,
                'fax_no' => $fax_no,
                'token' => $token
            ];
            return view('sokos.detail', $data);
        }
        catch(\Exception $e)
        {
            Utility::error($request, $e);
        }
    }

    /**
     * 新規作成画面
     *
     * @route GET /sokos/new
     * @see routes/master/sokos.php
     * @param Request $request
     * @return void
     */
    public function new(Request $request)
    {
        try
        {
            // トークンを生成
            $token = Session::generateToken();

            $prefectures = Prefecture::all();
            // セッションから値を取得
            $soko_name = Session::get('soko_name', '');
            $soko_ryaku_name = Session::get('soko_ryaku_name', '');
            $prefectures_id = Session::get('prefectures_id', 40);
            $zip_code_1 = Session::get('zip_code_1', '');
            $zip_code_2 = Session::get('zip_code_2', '');
            $address_1 = Session::get('address_1', '');
            $address_2 = Session::get('address_2', '');
            $tel_no = Session::get('tel_no', '');
            $fax_no = Session::get('fax_no', '');
            $email = Session::get('email', '');

            $data = [
                'prefectures' => $prefectures,
                'soko_name' => $soko_name,
                'soko_ryaku_name' => $soko_ryaku_name,
                'prefectures_id' => $prefectures_id,
                'zip_code_1' => $zip_code_1,
                'zip_code_2' => $zip_code_2,
                'address_1' => $address_1,
                'address_2' => $address_2,
                'tel_no' => $tel_no,
                'fax_no' => $fax_no,
                'email' => $email,
                'token' => $token
            ];
            return view('sokos.new', $data);
        }
        catch(\Exception $e)
        {
            Utility::error($request, $e);
        }
    }

    /**
     * 確認画面
     *
     * @route POST /sokos/confirm/{soko_id?}
     * @see routes/master/sokos.php
     * @param SokoRequest $request
     * @return void
     */
    public function confirm(SokoRequest $request)
    {
        try
        {
            // トークンを取得
            $token = $request->token;

            // 出荷先ID取得
            $soko_id = $request->soko_id??null;

            // 入力値取得
            $mishiyo_flag = $request->input('mishiyo_flag')??0;
            $soko_name = $request->input('soko_name');
            $soko_ryaku_name = $request->input('soko_ryaku_name');
            $prefectures_id = $request->input('prefectures_id');
            $prefecture = Prefecture::find($prefectures_id);
            $zip_code_1 = $request->input('zip_code_1');
            $zip_code_2 = $request->input('zip_code_2');
            $address_1 = $request->input('address_1');
            $address_2 = $request->input('address_2');
            $email = $request->input('email');
            $tel_no = $request->input('tel_no');
            $fax_no = $request->input('fax_no');

            // 未使用に変更されたら
            if($mishiyo_flag == 1)
            {
                // 未使用に変更
                $sokos = Soko::find($soko_id);
                $sokos->mishiyo_flag = 1;
                $sokos->save();

                // 一覧画面にリダイレクト
                return redirect()->route('sokos');
            }

            // 入力値をセッションに保存
            Session::set('soko_name', $soko_name);
            Session::set('soko_ryaku_name', $soko_ryaku_name);
            Session::set('prefectures_id', $prefectures_id);
            Session::set('zip_code_1', $zip_code_1);
            Session::set('zip_code_2', $zip_code_2);
            Session::set('address_1', $address_1);
            Session::set('address_2', $address_2);
            Session::set('email', $email);
            Session::set('tel_no', $tel_no);
            Session::set('fax_no', $fax_no);
            Session::set('confirm', true);

            // ルートを設定
            $form_route = isset($soko_id) ? route('sokos.save', ['soko_id'=>$soko_id]) : route('sokos.save');
            $back_route = isset($soko_id) ? route('sokos.detail', ['soko_id'=>$soko_id]) : route('sokos.new');

            $data = [
                'soko_name' => $soko_name,
                'soko_ryaku_name' => $soko_ryaku_name,
                'prefecture' => $prefecture,
                'zip_code_1' => $zip_code_1,
                'zip_code_2' => $zip_code_2,
                'address_1' => $address_1,
                'address_2' => $address_2,
                'email' => $email,
                'tel_no' => $tel_no,
                'fax_no' => $fax_no,
                'form_route' => $form_route,
                'back_route' => $back_route,
                'token' => $token
            ];
            return view('sokos.confirm', $data);
        }
        catch(\Exception $e)
        {
            Utility::error($request, $e);
        }
    }

    /**
     * 保存処理
     *
     * @route POST /sokos/save/{soko_id?}
     * @see routes/master/sokos.php
     * @param Request $request
     * @return void
     */
    public function save(Request $request)
    {
        try
        {
            // トークンを取得
            $token = $request->token;

            $soko_id = $request->soko_id??null;

            // トークンをセッションのトークンと比較
            Session::checkToken($token);

            // セッションから値を取得
            $soko_name = Session::get('soko_name', '');
            $soko_ryaku_name = Session::get('soko_ryaku_name', '');
            $prefectures_id = Session::get('prefectures_id', 40);
            $zip_code_1 = Session::get('zip_code_1', '');
            $zip_code_2 = Session::get('zip_code_2', '');
            $address_1 = Session::get('address_1', '');
            $address_2 = Session::get('address_2', '');
            $email = Session::get('email', '');
            $tel_no = Session::get('tel_no', '');
            $fax_no = Session::get('fax_no', '');

            DB::beginTransaction();
            try
            {
                $soko = isset($soko_id) ? Soko::find($soko_id) : new Soko();

                // 新規だったら
                if(is_null($soko_id))
                {
                    // ユーザIDをインクリメント
                    $maxSokoId = Soko::max('soko_id');
                    $soko->soko_id = ++$maxSokoId;
                }
                $soko->mishiyo_flag = 0;
                $soko->soko_name = $soko_name;
                $soko->soko_ryaku_name = $soko_ryaku_name;
                $soko->prefectures_id = $prefectures_id;
                $soko->zip_code_1 = $zip_code_1;
                $soko->zip_code_2 = $zip_code_2;
                $soko->address_1 = $address_1;
                $soko->address_2 = $address_2;
                $soko->email = $email;
                $soko->tel_no = $tel_no;
                $soko->fax_no = $fax_no;
                $soko->save();

                DB::commit();
            }
            catch(\Exception $e)
            {
                Log::error($request, $e);
                DB::rollback();
                throw $e;
            }

            self::resetSessions();
            return redirect()->route('sokos.complete');
        }
        catch(\Exception $e)
        {
            Utility::error($request, $e);
        }
    }

    /**
     * 完了画面
     *
     * @route GET /sokos/complete
     * @see routes/master/sokos.php
     * @param Request $request
     * @return void
     */
    public function complete(Request $request)
    {
        return view('sokos.complete');
    }

    // セッション値をリセットする
    public static function resetSessions()
    {
        Session::reset('soko_name');
        Session::reset('soko_ryaku_name');
        Session::reset('prefectures_id');
        Session::reset('zip_code_1');
        Session::reset('zip_code_2');
        Session::reset('address_1');
        Session::reset('address_2');
        Session::reset('email');
        Session::reset('tel_no');
        Session::reset('fax_no');
        Session::reset('confirm');
    }
}
