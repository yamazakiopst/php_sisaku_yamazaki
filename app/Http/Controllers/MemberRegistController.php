<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRegistForm;
use App\Services\MemberRegistService;
use Illuminate\Http\Request;

class MemberRegistController extends Controller
{
    /**
     * 入力画面初期表示
     */
    public function index()
    {
        return view('member.index');
    }

    /**
     * 確認ボタン押下
     */
    public function confirm(MemberRegistForm $request)
    {
        //入力値取得
        $form = [
            'name' => $request->input('name'),
            'password' => $request->input('password1'),
            'age' => $request->input('age'),
            'sex' => $request->input('sex'),
            'zip' => $request->input('zip'),
            'address' => $request->input('address'),
            'tel' => $request->input('tel'),
        ];
        //確認画面へ
        return view('member.confirm', compact('form'));
    }

    /**
     * 戻る・登録ボタン押下
     */
    public function regist(Request $request)
    {
        //入力値を取得
        $form = [
            'name' => $request->input('name'),
            'password1' => $request->input('password'),
            'password2' => $request->input('password'),
            'age' => $request->input('age'),
            'sex' => $request->input('sex'),
            'zip' => $request->input('zip'),
            'address' => $request->input('address'),
            'tel' => $request->input('tel'),
        ];

        /* 戻るボタン押下時 */
        if ($request->input('back') !== null) {
            //入力画面へ戻る
            return redirect()->route('member.index')->withInput($form);
        }

        /** 登録ボタン押下時 */
        if ($request->input('confirm') !== null) {
            //会員番号採番
            $member_no = MemberRegistService::createMemberNo();

            //登録値を設定
            $member_info = MemberRegistService::setOnlineMember($form, $member_no);

            //登録処理
            if (!MemberRegistService::registOnlineMember($member_info)) {
                //エラー時は共通エラー画面へ
                return redirect()->route('error');
            }

            //完了画面に会員番号を出力する
            return view('member.result', compact('member_no'));
        }
    }
}
