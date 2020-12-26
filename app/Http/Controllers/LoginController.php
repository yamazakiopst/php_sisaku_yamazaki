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
        //ログイン後に注文画面へ戻るかを制御する
        LoginService::updateReturnFlag();

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
        $user = LoginService::getOnlineMember($member_no, $password);

        //ユーザーが存在しない場合
        if (LoginService::checkUser($user)) {
            //MSG012を出力
            $message = config('const.message.MSG012');
            return redirect()->route('login.index')->with('message', $message);
        }

        //ログイン処理
        LoginService::login($user[0]);

        if (LoginService::checkReturnFlag()) {
            //注文画面から遷移した場合は戻る
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
