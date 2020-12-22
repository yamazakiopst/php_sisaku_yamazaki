<?php

namespace App\Http\Controllers;

use App\Models\OnlineOrder;
use App\Models\OnlineOrderList;
use App\Models\OnlineProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * かご画面初期表示
     */
    public function index()
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
            //入力値取得
            $product_codes = $request->input('product_code');

            //未選択の場合
            if ($product_codes === null) {
                //MSG009を出力
                $message = config('const.message.MSG009');
                return redirect()->route('cart.index')->with('message', $message);
            }

            //選択された商品を全て削除
            $cart = session('cart');
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
            //入力値取得
            $counts = $request->input('count');

            //未入力の場合
            if ($counts === null) {
                //MSG007を出力
                $message = config('const.message.MSG007');
                return redirect()->route('cart.index')->with('message', $message)->withInput(['count' => $counts]);
            }

            //購入数チェック
            foreach ($counts as $count) {
                if (!(is_numeric($count) && 1 <= $count && $count <= 999)) {
                    //MSG007を出力
                    $message = config('const.message.MSG007');
                    return redirect()->route('cart.index')->with('message', $message)->withInput(['count' => $counts]);
                }
            }

            //それぞれの商品について在庫チェック
            foreach (array_keys(session('cart')['products']) as $index => $product_code) {
                //在庫取得
                $ONLINE_PRODUCT = OnlineProduct::find($product_code);
                $stock = $ONLINE_PRODUCT->STOCK_COUNT;

                //チェック（購入数 > 在庫）
                if ($counts[$index] > $stock) {
                    //MSG008を出力
                    $message = config('const.message.MSG008');
                    return redirect()->route('cart.index')->with('message', $message)->withInput(['count' => $counts]);
                }

                //在庫がある場合、カートの個数を更新する
                $cart = session('cart');
                $cart['products'][$product_code] = $counts[$index];
                session()->put('cart', $cart);
            }

            //確認画面へ
            return redirect()->route('cart.confirm');
        }
    }

    /**
     * 注文確認画面表示
     */
    public function confirm(Request $request)
    {
        //画面表示用変数の初期化
        $products = [];

        //カートが存在する場合
        if (session()->has('cart')) {
            //商品コード昇順でDBから商品情報を取得する
            $keys = array_keys(session('cart')['products']);
            $ONLINE_PRODUCT = OnlineProduct::find($keys)->sortBy('PRODUCT_CODE');

            foreach ($ONLINE_PRODUCT as $product) {
                //画面表示内容を設定
                $view = [
                    'code' => $product->PRODUCT_CODE,
                    'name' => $product->PRODUCT_NAME,
                    'maker' => $product->MAKER,
                    'price' => $product->UNIT_PRICE,
                    'count' => session('cart')['products'][$product->PRODUCT_CODE]
                ];
                //ソート順に詰めていく
                array_push($products, $view);
            }
        }
        return view('cart.confirm', compact('products'));
    }

    /**
     * 買い物をやめる・注文する（確認画面）
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
            if (!session()->has('login_user')) {
                //未ログインであれば、フラグを生成してログイン画面へ
                session()->put('order_return_flag', true);
                return redirect()->route('login.index');
            }

            //カートから商品取得
            $products = session('cart')['products'];

            //商品取り扱い確認
            foreach (array_keys($products) as $product_code) {
                $ONLINE_PRODUCT = OnlineProduct::where([
                    ['PRODUCT_CODE', $product_code],
                    ['DELETE_FLG', 0],
                ])->get();

                //取り扱い不可の場合
                if ($ONLINE_PRODUCT->count() === 0) {
                    //MSG010を出力
                    $message = str_replace('${product_code}', $product_code, config('const.message.MSG010'));
                    return redirect()->route('cart.confirm')->with('message', $message);
                }
            }

            //注文処理
            //トランザクション開始
            DB::beginTransaction();
            try {
                //会員番号と今までの注文回数からとりまとめ番号を採番
                $member_no = session('login_user')['member_no'];
                $order_count = OnlineOrder::where('MEMBER_NO', $member_no)->count();

                //会員番号0埋め11桁 + 注文回数36進数変換0埋め4桁（MAX1679617件）
                $collect_no = str_pad($member_no, 11, '0', STR_PAD_LEFT) . '_' .
                    str_pad(base_convert($order_count, 10, 36), 4, '0', STR_PAD_LEFT);

                //注文テーブルへの登録値を設定する（ORDER_NOは自動採番）
                $ONLINE_ORDER = new OnlineOrder;
                $ONLINE_ORDER->MEMBER_NO = $member_no;
                $ONLINE_ORDER->TOTAL_MONEY = $request->input('total_money');
                $ONLINE_ORDER->TOTAL_TAX = $request->input('total_tax');
                $ONLINE_ORDER->ORDER_DATE = now();
                $ONLINE_ORDER->COLLECT_NO = $collect_no;
                $ONLINE_ORDER->LAST_UPD_DATE = now();
                //注文テーブルへ登録
                $ONLINE_ORDER->save();

                //商品ごとに注文詳細登録と在庫の更新
                foreach ($products as $key => $value) {
                    //商品情報取得
                    $ONLINE_PRODUCT = OnlineProduct::where('PRODUCT_CODE', $key)->first();

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

                //最後にカート削除
                session()->forget('cart');
            } catch (\Exception $e) {
                //エラー時 ロールバックして共通エラー画面へ
                DB::rollback();
                return redirect()->route('error');
            }
            //注文完了画面へ
            return redirect()->route('cart.result')->with('order_complete_flag', true);
        }
    }

    /**
     * 注文完了画面
     */
    public function result()
    {
        return view('cart.result');
    }
}
