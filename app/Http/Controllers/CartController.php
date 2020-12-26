<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * かご画面初期表示
     */
    public function index()
    {
        //画面に表示する商品情報を取得する
        $products = CartService::setIndexProdcut();
        //かご画面へ
        return view('cart.index', compact('products'));
    }

    /**
     * 取り消し・買い物やめる・注文する（かご画面）
     */
    public function operate(Request $request)
    {
        /**
         * 取り消しボタン押下時
         */
        if ($request->input('delete') !== null) {
            //カートが存在しない場合、何もしない
            if (!session()->has('cart')) {
                return redirect()->route('cart.index');
            }

            //入力値取得
            $product_codes = $request->input('product_code');

            //未選択の場合
            if (CartService::checkSelects($product_codes)) {
                //MSG009を出力
                $message = config('const.message.MSG009');
                return redirect()->route('cart.index')->with('message', $message);
            }

            //選択された商品を全て削除
            CartService::delete($product_codes);

            //かご画面へ
            return redirect()->route('cart.index');
        }

        /**
         * 買い物をやめるボタン押下時
         */
        if ($request->input('forget') !== null) {
            //カート削除
            session()->forget('cart');
            //メニュー画面へ
            return redirect()->route('menu.user');
        }

        /**
         * 注文するボタン押下時
         */
        if ($request->input('order') !== null) {
            //カートが存在しない場合、何もしない
            if (!session()->has('cart')) {
                return redirect()->route('cart.index');
            }

            //入力値取得
            $counts = $request->input('count');

            //購入数チェック
            if (CartService::checkCounts($counts)) {
                //MSG007を出力
                $message = config('const.message.MSG007');
                return redirect()->route('cart.index')->with('message', $message)->withInput(['count' => $counts]);
            }

            //在庫チェック
            if (CartService::checkStocks($counts)) {
                //MSG008を出力
                $message = config('const.message.MSG008');
                return redirect()->route('cart.index')->with('message', $message)->withInput(['count' => $counts]);
            }

            //カートの個数を更新する
            CartService::updateCart($counts);

            //確認画面へ
            return redirect()->route('cart.confirm');
        }
    }

    /**
     * 注文確認画面表示
     */
    public function confirm(Request $request)
    {
        //画面に表示する商品情報を取得する
        $products = CartService::setConfirmProdcut();
        //確認画面へ
        return view('cart.confirm', compact('products'));
    }

    /**
     * 買い物をやめる・注文する（注文確認画面）
     */
    public function order(Request $request)
    {
        /**
         * 買い物をやめるボタン押下時
         */
        if ($request->input('forget') !== null) {
            //カート削除
            session()->forget('cart');
            //メニュー画面へ
            return redirect()->route('menu.user');
        }

        /**
         * 注文するボタン押下時
         */
        if ($request->input('order') !== null) {
            //ログインチェック
            if (CartService::checkLogin()) {
                return redirect()->route('login.index');
            }

            //商品取り扱いチェック
            $end_product = CartService::checkProduct();
            if ($end_product !== null) {
                //MSG010を出力
                $message = str_replace('${product_code}', $end_product, config('const.message.MSG010'));
                return redirect()->route('cart.confirm')->with('message', $message);
            }

            //入力値取得
            $total_money = $request->input('total_money');
            $total_tax = $request->input('total_tax');

            //注文処理
            if (!CartService::order($total_money, $total_tax)) {
                //エラー時は共通エラー画面に遷移する
                return redirect()->route('error');
            }
            //注文完了画面へ
            return view('cart.result');
        }
    }
}
