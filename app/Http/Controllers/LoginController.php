<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginForm;
use App\Services\LoginService;

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
     * ログインボタン押下
     */
    public function auth(LoginForm $request)
    {
        //入力値取得
        $member_no = $request->input('member_no');
        $password = $request->input('password');

        //入力されたユーザー取得
        $user = LoginService::userCheck($member_no, $password);

        //ユーザーが存在しない場合
        if ($user->count() === 0) {
            //MSG012を出力
            $message = config('const.message.MSG012');
            return redirect()->route('login.index')->with('message', $message);
        }

        //ログイン処理
        LoginService::login($user[0]);

        //注文確認画面からの遷移時
        if (session()->has('order_return_flag')) {
            //フラグを削除して注文画面へ戻る
            session()->forget('order_return_flag');
            return redirect()->route('cart.confirm');
        }
        //上記以外はメニュー画面へ
        return redirect()->route('menu.user');
    }

    /**
     * ログアウトボタン押下
     */
    public function logout()
    {
        //session全削除
        session()->flush();
        //ログイン画面へ
        return redirect()->route('login.index');
    }
}
