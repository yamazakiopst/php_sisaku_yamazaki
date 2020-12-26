<?php

namespace App\Services;

use App\Models\OnlineCategory;
use App\Models\OnlineProduct;

class ProductService
{
    /**
     * カテゴリー一覧を取得する
     * return:カテゴリー一覧
     */
    public static function getOnlieCategory()
    {
        $ONLINE_CATEGORY = OnlineCategory::select('CTGR_ID as ctgr_id', 'NAME as name')->get();
        return $ONLINE_CATEGORY;
    }

    /**
     * 条件に合った商品情報を取得する
     * return:商品情報
     */
    public static function searchProduct($search_form)
    {
        //検索条件・ページ数をセッションに保持しておく
        session()->put('search_form', $search_form);

        //検索
        $ONLINE_PRODUCT = OnlineProduct::select(
            'PRODUCT_CODE as product_code',
            'PRODUCT_NAME as product_name',
            'MAKER as maker',
            'UNIT_PRICE as unit_price',
            'MEMO as memo'
        )->where('DELETE_FLG', '0')
            //カテゴリー
            ->when($search_form['category'], function ($query, $category_id) {
                return $query->where('CATEGORY_ID', $category_id);
            })
            //商品名
            ->when($search_form['product_name'], function ($query, $product_name) {
                return $query->where('PRODUCT_NAME', 'like', "%$product_name%");
            })
            //販売元
            ->when($search_form['maker'], function ($query, $maker) {
                return $query->where('MAKER', 'like', "%$maker%");
            })
            //金額上限
            ->when($search_form['max_price'], function ($query, $max_price) {
                return $query->where('UNIT_PRICE', '<=', $max_price);
            })
            //金額下限
            ->when($search_form['min_price'], function ($query, $min_price) {
                return $query->where('UNIT_PRICE', '>=', $min_price);
            })
            //1ページ表示数
            ->paginate(10);

        return $ONLINE_PRODUCT;
    }

    /**
     * 商品検索の結果数を確認する
     * return:
     *  true  0件
     *  false 0件でない
     */
    public static function checkProduct($products)
    {
        if ($products === null || $products->count() === 0) {
            return true;
        }
        return false;
    }

    /**
     * 商品が選択されているかを確認する
     * return:
     *  true  未選択
     *  false 選択有
     */
    public static function checkSelects($selects)
    {
        if ($selects === null) {
            return true;
        }
        return false;
    }

    /**
     * 選択された商品の購入数が入力されているかを確認する
     * return:
     *  true  未入力
     *  false 入力有
     */
    public static function checkCounts($selects, $counts)
    {
        //選択された商品についてのみ確認
        foreach ($selects as $select) {
            if (!array_key_exists($select, $counts)) {
                //商品選択有り、購入数未入力
                return true;
            }
            if (!(is_numeric($counts[$select]) && 1 <= $counts[$select] && $counts[$select] <= 999)) {
                //1~999の数字以外
                return true;
            }
        }
        return false;
    }

    /**
     * 商品在庫が足りているかを確認する
     * return:
     *  true  在庫不足
     *  false 在庫有り
     */
    public static function checkStocks($selects, $counts, $product_codes)
    {
        foreach ($selects as $select) {
            //商品コード、購入数
            $product_code = $product_codes[$select];
            $input_count = $counts[$select];

            //商品在庫取得
            $ONLINE_PRODUCT = OnlineProduct::find($product_code);
            $stock = $ONLINE_PRODUCT->STOCK_COUNT;

            //カート内の購入数取得
            $cart_count = 0;
            if (session()->has('cart') && array_key_exists($product_code, session('cart')['products'])) {
                $cart_count = session('cart')['products'][$product_code];
            }

            //在庫チェック（購入数 + カート内の購入数 > 在庫）
            if ($input_count + $cart_count > $stock) {
                return true;
            }
        }
        return false;
    }

    /**
     * カートに商品情報を追加する
     */
    public static function addProducts($selects, $counts, $product_codes)
    {
        //カート取得
        $cart = session('cart');

        foreach ($selects as $select) {
            //商品コード、購入数
            $product_code = $product_codes[$select];
            $input_count = $counts[$select];

            //カート内の購入数
            $cart_count = 0;
            if (session()->has('cart') && array_key_exists($product_code, session('cart')['products'])) {
                $cart_count = session('cart')['products'][$product_code];
            }

            if ($cart === null) {
                //カートがなければ初期生成
                $cart = [
                    'member_no' => session()->has('login_user') ? session('login_user')['member_no'] : null,
                    'products' => [$product_code => intval($input_count)]
                ];
            } else {
                //カートがあれば追加・上書き
                $cart['products'][$product_code] = intval($input_count + $cart_count);
            }
        }
        //セッションに保持
        session()->put('cart', $cart);
    }

    /**
     * 登録完了画面に表示する商品情報の設定を行う
     * return:商品情報
     */
    public static function setResultProduct()
    {
        //表示用変数初期化
        $products = [];

        //カートがある場合
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
     * 商品詳細画面に表示する商品情報の設定を行う
     * return:商品情報
     */
    public static function setDetaiProduct($product_code)
    {
        //商品情報取得
        $ONLINE_PRODUCT = OnlineProduct::find($product_code);

        $product = [
            'product_name' => $ONLINE_PRODUCT->PRODUCT_NAME,
            'picture' => $ONLINE_PRODUCT->PICTURE_NAME,
            'memo' => $ONLINE_PRODUCT->MEMO,
            'price' => $ONLINE_PRODUCT->UNIT_PRICE,
            'product_code' => $ONLINE_PRODUCT->PRODUCT_CODE
        ];
        return $product;
    }

    /**
     * 購入数が入力されているかを確認する
     * return:
     *  true  未入力
     *  false 入力有
     */
    public static function checkCount($count)
    {
        if (!(is_numeric($count) && 1 <= $count && $count <= 999)) {
            //1~999の数字以外
            return true;
        }
        return false;
    }

    /**
     * 商品在庫が足りているかを確認する
     * return:
     *  true  在庫不足
     *  false 在庫有り
     */
    public static function checkStock($product_code, $count)
    {
        //商品情報取得
        $ONLINE_PRODUCT = OnlineProduct::find($product_code);

        //在庫
        $stock = $ONLINE_PRODUCT->STOCK_COUNT;

        //カート内の購入数取得
        $cart_count = 0;
        if (session()->has('cart') && array_key_exists($product_code, session('cart')['products'])) {
            $cart_count = session('cart')['products'][$product_code];
        }

        //在庫チェック（購入数 + カート内の購入数 > 在庫）
        if ($count + $cart_count > $stock) {
            return true;
        }
        return false;
    }

    /**
     * カートに商品情報を追加する
     */
    public static function addProduct($product_code, $count)
    {
        //カート取得
        $cart = session('cart');

        if ($cart === null) {
            //カートがなければ初期生成
            $cart = [
                'member_no' => session()->has('login_user') ? session('login_user')['member_no'] : null,
                'products' => [$product_code => intval($count)]
            ];
        } else {
            //カートがあれば既存の購入数取得
            $cart_count = 0;
            if (array_key_exists($product_code, session('cart')['products'])) {
                $cart_count = session('cart')['products'][$product_code];
            }
            //合計値で上書き・追加
            $cart['products'][$product_code] = intval($count + $cart_count);
        }
        //セッションに保持
        session()->put('cart', $cart);
    }
}
