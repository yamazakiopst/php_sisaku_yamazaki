<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginForm;
use App\Models\OnlineMember;

class LoginController extends Controller
{
    /**
     * ログイン画面初期表示
     */
    public function index()
    {
        //前画面が注文確認orログイン画面(認証エラー)以外の場合
        if (!(parse_url(url()->previous())['path'] === '/cart/confirm' ||
            parse_url(url()->previous())['path'] === '/login/index')) {
            //注文画面へ戻るフラグ削除
            session()->forget('order_return_flag');
        }
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
        $ONLINE_MEMBER = OnlineMember::where([
            ['MEMBER_NO', $member_no],
            ['PASSWORD', $password],
            ['DELETE_FLG', '0'],
        ])->get();

        //ユーザーが存在しない場合
        if ($ONLINE_MEMBER->count() === 0) {
            //MSG012を出力
            $message = config('const.message.MSG012');
            return redirect()->route('login.index')->with('message', $message);
        }

        //会員番号とユーザー名をセッションに保持
        $login_user = [
            'member_no' => $member_no,
            'user_name' => $ONLINE_MEMBER[0]->NAME
        ];
        session()->put('login_user', $login_user);

        //注文確認画面からの遷移時
        if (session()->has('order_return_flag')) {
            //フラグを削除して注文確認画面へ戻る
            session()->forget('order_return_flag');
            return redirect()->route('cart.confirm');
        }
        //上記以外はメニュー画面へ
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
