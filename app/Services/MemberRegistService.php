<?php

namespace App\Services;

use App\Models\OnlineMember;
use Illuminate\Support\Facades\DB;

class MemberRegistService
{
    /**
     * 会員番号を採番する
     */
    public static function createMemberNo()
    {
        //会員番号の最大値+1として採番
        $max = OnlineMember::max('MEMBER_NO');
        return $max + 1;
    }

    /**
     * 会員情報の登録値を設定する
     */
    public static function setOnlineMember($form, $member_no)
    {
        //登録値を設定
        $ONLINE_MEMBER = new OnlineMember;
        $ONLINE_MEMBER->MEMBER_NO = $member_no;
        $ONLINE_MEMBER->PASSWORD = $form['password1'];
        $ONLINE_MEMBER->NAME = $form['name'];
        $ONLINE_MEMBER->AGE = $form['age'];
        if ($form['sex'] === '0') {
            $ONLINE_MEMBER->SEX = 'M';
        } else if ($form['sex'] === '1') {
            $ONLINE_MEMBER->SEX = 'F';
        }
        $ONLINE_MEMBER->ZIP = $form['zip'];
        $ONLINE_MEMBER->ADDRESS = $form['address'];
        $ONLINE_MEMBER->TEL = $form['tel'];
        $ONLINE_MEMBER->REGISTER_DATE = now();
        $ONLINE_MEMBER->LAST_UPD_DATE = now();
        return $ONLINE_MEMBER;
    }

    /**
     * 会員情報の登録
     */
    public static function registOnlineMember($member_info)
    {
        //トランザクション開始
        DB::beginTransaction();
        try {
            //登録
            $member_info->save();
            DB::commit();
        } catch (\Exception $e) {
            //エラー時はロールバック
            DB::rollback();
            return false;
        }
        return true;
    }
}
