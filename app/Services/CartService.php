<?php

namespace App\Services;

use App\Models\OnlineOrder;
use App\Models\OnlineOrderList;
use App\Models\OnlineProduct;
use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * かご画面表示情報を設定する
     * return:商品情報
     */
    public static function setIndexProdcut()
    {
        //画面表示用変数の初期化
        $products = [];

        //カートが存在する場合
        if (session()->has('cart')) {
            foreach (session('cart')['products'] as $key => $value) {
                //商品コードから商品情報取得
                $ONLINE_PRODUCT = OnlineProduct::find($key);

                //画面表示内容を設定
                $view = [
                    'code' => $ONLINE_PRODUCT->PRODUCT_CODE,
                    'name' => $ONLINE_PRODUCT->PRODUCT_NAME,
                    'maker' => $ONLINE_PRODUCT->MAKER,
                    'price' => $ONLINE_PRODUCT->UNIT_PRICE,
                    'count' => $value
                ];
                //カート格納順に詰めていく
                array_push($products, $view);
            }
        }
        return $products;
    }

    /**
     * 商品の選択有無を確認する
     * return:
     *  true  未選択
     *  false 選択有
     */
    public static function checkSelects($product_codes)
    {
        if ($product_codes === null) {
            return true;
        }
        return false;
    }

    /**
     * 選択された商品をカートから削除する
     */
    public static function delete($product_codes)
    {
        //カート取得
        $cart = session('cart');

        //削除
        foreach ($product_codes as $code) {
            unset($cart['products'][$code]);
        }

        //カート更新
        if (count($cart['products']) === 0) {
            //削除後0件ならカートごと削除
            session()->forget('cart');
        } else {
            //商品が残っていれば、既存値を引き継ぐ
            session()->put('cart', $cart);
        }
    }

    /**
     * 購入数を確認する
     * return:
     *  true  未入力
     *  false 入力有
     */
    public static function checkCounts($counts)
    {
        foreach ($counts as $count) {
            if (!(is_numeric($count) && 1 <= $count && $count <= 999)) {
                //1~999の数字以外
                return true;
            }
        }
        return false;
    }

    /**
     * 商品在庫を確認する
     * return:
     *  true  在庫なし
     *  false 在庫あり
     */
    public static function checkStocks($counts)
    {
        //カート取得
        $cart = session('cart');

        foreach (array_keys($cart['products']) as $index => $product_code) {
            //在庫取得
            $ONLINE_PRODUCT = OnlineProduct::find($product_code);
            $stock = $ONLINE_PRODUCT->STOCK_COUNT;

            //チェック（購入数 > 在庫）
            if ($counts[$index] > $stock) {
                return true;
            }
        }
        return false;
    }

    /**
     * カートの商品数を入力された個数に更新する
     */
    public static function updateCart($counts)
    {
        //カート取得
        $cart = session('cart');

        //更新
        foreach (array_keys($cart['products']) as $index => $product_code) {
            $cart['products'][$product_code] = $counts[$index];
        }
        session()->put('cart', $cart);
    }

    /**
     * 注文確認画面表示情報を設定する
     * return:商品情報
     */
    public static function setConfirmProdcut()
    {
        //画面表示用変数の初期化
        $products = [];

        //カートが存在する場合
        if (session()->has('cart')) {
            //商品情報を商品コード昇順で取得
            $keys = array_keys(session('cart')['products']);
            $ONLINE_PRODUCT = OnlineProduct::find($keys)->sortBy('PRODUCT_CODE');

            //ソート順に表示情報を詰めていく
            foreach ($ONLINE_PRODUCT as $product) {
                //画面表示内容を設定
                $view = [
                    'code' => $product->PRODUCT_CODE,
                    'name' => $product->PRODUCT_NAME,
                    'maker' => $product->MAKER,
                    'price' => $product->UNIT_PRICE,
                    'count' => session('cart')['products'][$product->PRODUCT_CODE]
                ];
                array_push($products, $view);
            }
        }
        return $products;
    }

    /**
     * ログイン済みかの確認を行う
     * rerturn:
     *  true  未ログイン
     *  false ログイン済み
     */
    public static function checkLogin()
    {
        if (!session()->has('login_user')) {
            //未ログインの場合、注文画面へ戻るフラグを生成する
            session()->put('return_flag', true);
            return true;
        }
        return false;
    }

    /**
     * 商品が取り扱い中かを確認する
     * return:扱い不可の商品コード
     */
    public static function checkProduct()
    {
        //カート取得
        $cart = session('cart');

        //商品取り扱い確認
        foreach (array_keys($cart['products']) as $product_code) {
            $ONLINE_PRODUCT = OnlineProduct::where([
                ['PRODUCT_CODE', $product_code],
                ['DELETE_FLG', '0'],
            ])->get();

            //取り扱い不可の場合
            if ($ONLINE_PRODUCT->count() === 0) {
                return $product_code;
            }
        }
        return null;
    }

    /**
     * 注文処理を行う
     * return:
     *  true  登録完了
     *  false 登録失敗
     */
    public static function order($total_money, $total_tax)
    {
        //トランザクション開始
        DB::beginTransaction();
        try {
            //会員番号取得
            $member_no = session('login_user')['member_no'];
            //今までの注文回数取得
            $order_count = OnlineOrder::where('MEMBER_NO', $member_no)->count() + 1;

            //会員番号0埋め11桁 + 注文回数36進数変換0埋め4桁（MAX1679616件）として注文番号を採番する
            $collect_no = str_pad($member_no, 11, '0', STR_PAD_LEFT) . '_' .
                str_pad(base_convert($order_count, 10, 36), 4, '0', STR_PAD_LEFT);

            //注文テーブルへの登録値を設定する（ORDER_NOは自動採番）
            $ONLINE_ORDER = new OnlineOrder;
            $ONLINE_ORDER->MEMBER_NO = $member_no;
            $ONLINE_ORDER->TOTAL_MONEY = $total_money;
            $ONLINE_ORDER->TOTAL_TAX = $total_tax;
            $ONLINE_ORDER->ORDER_DATE = now();
            $ONLINE_ORDER->COLLECT_NO = $collect_no;
            $ONLINE_ORDER->LAST_UPD_DATE = now();
            //注文テーブルへ登録
            $ONLINE_ORDER->save();

            //カート取得
            $cart = session('cart');
            //商品ごとに注文詳細テーブルへの登録と商品在庫の更新
            foreach ($cart['products'] as $key => $value) {
                //商品情報取得
                $ONLINE_PRODUCT = OnlineProduct::find($key);

                //注文詳細テーブルへの登録値を設定（明細番号は自動採番）
                $ONLINE_ORDER_LIST = new OnlineOrderList;
                $ONLINE_ORDER_LIST->COLLECT_NO = $collect_no;
                $ONLINE_ORDER_LIST->PRODUCT_CODE = $key;
                $ONLINE_ORDER_LIST->ORDER_COUNT = $value;
                $ONLINE_ORDER_LIST->ORDER_PRICE = $ONLINE_PRODUCT->UNIT_PRICE;
                //注文詳細テーブルへ登録
                $ONLINE_ORDER_LIST->save();

                //在庫更新
                $ONLINE_PRODUCT->STOCK_COUNT -= $value;
                $ONLINE_PRODUCT->LAST_UPD_DATE = now();
                //商品テーブル更新
                $ONLINE_PRODUCT->save();
            }
            //一括コミット
            DB::commit();

            //コミット完了後にカート削除
            session()->forget('cart');
        } catch (\Exception $e) {
            //エラー時 ロールバックして共通エラー画面へ
            DB::rollback();
            return false;
        }
        return true;
    }
}
