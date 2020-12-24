<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRegistForm;
use App\Models\OnlineMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * 確認画面表示
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
     * 戻る・登録処理
     */
    public function regist(Request $request)
    {
        /* 戻るボタン押下時 */
        if ($request->input('back') !== null) {
            //入力値を保持
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
            //入力画面へ
            return redirect()->route('member.index')->withInput($form);
        }

        /** 登録ボタン押下時 */
        if ($request->input('confirm') !== null) {
            //会員番号の最大値+1として採番
            $max = OnlineMember::max('MEMBER_NO');
            $member_no = $max + 1;

            //登録値を設定
            $ONLINE_MEMBER = new OnlineMember;
            $ONLINE_MEMBER->MEMBER_NO = $member_no;
            $ONLINE_MEMBER->PASSWORD = $request->input('password');
            $ONLINE_MEMBER->NAME = $request->input('name');
            $ONLINE_MEMBER->AGE = $request->input('age');
            if ($request->input('sex') === '0') {
                $ONLINE_MEMBER->SEX = 'M';
            } else if ($request->input('sex') === '1') {
                $ONLINE_MEMBER->SEX = 'F';
            }
            $ONLINE_MEMBER->ZIP = $request->input('zip');
            $ONLINE_MEMBER->ADDRESS = $request->input('address');
            $ONLINE_MEMBER->TEL = $request->input('tel');
            $ONLINE_MEMBER->REGISTER_DATE = now();
            $ONLINE_MEMBER->LAST_UPD_DATE = now();

            //トランザクション開始
            DB::beginTransaction();
            try {
                //登録
                $ONLINE_MEMBER->save();
                DB::commit();
            } catch (\Exception $e) {
                //エラー時、ロールバックして共通エラー画面へ
                DB::rollback();
                return redirect()->route('error');
            }

            //完了画面に会員番号を出力する
            return view('member.result', compact('member_no'));
        }
    }
}
