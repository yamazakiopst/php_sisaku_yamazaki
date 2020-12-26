<?php

namespace App\Services;

use App\Models\OnlineMember;

class LoginService
{
    /**
     * 入力されたユーザー情報を取得する
     * return:ユーザー情報
     */
    public static function getOnlineMember($member_no, $password)
    {
        //DBから一致するユーザーを取得
        $ONLINE_MEMBER = OnlineMember::where([
            ['MEMBER_NO', $member_no],
            ['PASSWORD', $password],
            ['DELETE_FLG', '0'],
        ])->get();

        return $ONLINE_MEMBER;
    }

    /**
     * ユーザーの存在確認を行う
     * return:
     *  true  存在しない
     *  false 存在する
     */
    public static function checkUser($user)
    {
        if ($user->count() === 0) {
            return true;
        }
        return false;
    }

    /**
     * ログイン情報をセッションに保持する
     */
    public static function login($user)
    {
        //取得した会員情報からIDと名前をログインセッションとして格納
        $login_user = [
            'member_no' => $user->MEMBER_NO,
            'user_name' => $user->NAME
        ];
        session()->put('login_user', $login_user);
    }

    /**
     * 注文画面へ戻るフラグを更新する
     */
    public static function updateReturnFlag()
    {
        //前画面が注文画面orログイン画面（認証エラー）以外の場合
        if (!(parse_url(url()->previous())['path'] === '/cart/confirm' ||
            parse_url(url()->previous())['path'] === '/login/index')) {
            //注文画面へ戻るフラグを削除する
            session()->forget('return_flag');
        }
    }

    /**
     * 注文画面へ戻るかを確認する
     * return:
     *  true  注文画面へ戻る
     *  false 戻らない
     */
    public static function checkReturnFlag()
    {
        //セッションに戻るフラグがある場合
        if (session()->has('return_flag')) {
            //フラグを削除する
            session()->forget('return_flag');
            return true;
        }
        return false;
    }
}
