<?php

namespace App\Services;

use App\Models\OnlineMember;

class LoginService
{
    /**
     * 入力されたユーザーが存在するかをチェックする
     */
    public static function userCheck($member_no, $password)
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
}
