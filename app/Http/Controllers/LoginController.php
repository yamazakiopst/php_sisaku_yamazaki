<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginForm;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * 初期表示
     */
    public function index()
    {
        return view('login.index');
    }

    /**
     * ログイン処理
     */
    public function auth(LoginForm $request)
    {
        //入力値取得
        $member_no = $request->input('member_no');
        $password = $request->input('password');

        //ユーザの存在チェック
        $user = DB::table('ONLINE_MEMBER')->select('NAME as name')->where([
            ['MEMBER_NO', $member_no],
            ['PASSWORD', $password],
            ['DELETE_FLG', 0],
        ])->get();

        //認証失敗
        if (count($user) !== 1) {
            //MSG012を出力
            $message = config('const.message.MSG012');
            return redirect()->route('login.index')->with('message', $message);
        }

        //認証成功時 会員番号とユーザー名をセッションに保持
        $login_user =
            [
                'no' => $member_no,
                'name' => $user[0]->name
            ];
        session()->put('login_user', $login_user);

        /**
         * TODO 遷移元から遷移先を決定する
         */
        return redirect()->route('menu.user');
    }

    /**
     * ログアウト
     */
    public function logout()
    {
        //session全削除
        session()->flush();
        //ログイン画面へ
        return redirect()->route('login.index');
    }
}
