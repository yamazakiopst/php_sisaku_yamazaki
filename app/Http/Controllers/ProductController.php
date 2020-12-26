<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSearchForm;
use App\Models\OnlineProduct;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * 検索画面初期表示
     */
    public function index()
    {
        //カテゴリーの取得
        $categories = ProductService::getOnlieCategory();
        return view('product.index', compact('categories'));
    }

    /**
     * 検索処理
     */
    public function search(ProductSearchForm $request)
    {
        //カテゴリーの取得
        $categories = ProductService::getOnlieCategory();

        //入力値取得
        $category_id = $request->input('category');
        $product_name = $request->input('product_name');
        $maker = $request->input('maker');
        $max_price = $request->input('max_price');
        $min_price = $request->input('min_price');
        $page = $request->input('page');

        //入力値保持
        $search_form = [
            'category' => $category_id,
            'product_name' => $product_name,
            'maker' => $maker,
            'max_price' => $max_price,
            'min_price' => $min_price,
            'page' => $page
        ];

        //検索処理
        $products = ProductService::searchProduct($search_form);

        //検索結果数の確認
        if (ProductService::checkProduct($products)) {
            //MSG005を出力
            $message = config('const.message.MSG005');
            return view('product.index', compact('categories', 'search_form', 'message'));
        }

        //検索結果表示
        return view('product.index', compact('categories', 'products', 'search_form'));
    }

    /**
     * 買い物かごに入れる（商品検索）
     */
    public function add(Request $request)
    {
        //入力値取得
        $selects = $request->input('select');
        $counts = $request->input('count');
        $product_codes = $request->input('product_code');

        //選択チェック
        if (ProductService::checkSelects($selects)) {
            //MSG006を出力
            $message = config('const.message.MSG006');
            //検索状態は維持する
            $search_form = session('search_form');
            return redirect()->route('product.search', $search_form)->with('message', $message)->withInput(['count' => $counts]);
        }

        //購入数チェック
        if (ProductService::checkCounts($selects, $counts)) {
            //MSG007を出力
            $message = config('const.message.MSG007');
            //検索状態は維持する
            $search_form = session('search_form');
            return redirect()->route('product.search', $search_form)->with('message', $message)->withInput(['select' => $selects, 'count' => $counts]);
        }

        //在庫チェック
        if (ProductService::checkStocks($selects, $counts, $product_codes)) {
            //MSG008を出力
            $message = config('const.message.MSG008');
            return redirect()->route('product.search')->with('message', $message)->withInput(['select' => $selects, 'count' => $counts]);
        }

        //カートに追加
        ProductService::addProducts($selects, $counts, $product_codes);

        //完了画面の表示情報設定
        $products = ProductService::setResultProduct();

        //完了画面へ
        return view('product.result', compact('products'));
    }

    /**
     * 商品詳細画面表示
     */
    public function detail($product_code)
    {
        //商品コードと一致するデータを取得する
        $ONLINE_PRODUCT = OnlineProduct::find($product_code);

        //表示内容の設定
        $product = ProductService::setDetaiProduct($ONLINE_PRODUCT);

        //商品詳細画面へ
        return view('product.detail', compact('product'));
    }

    /**
     * 買い物かごに入れる（商品詳細）
     */
    public function addFromDetail(Request $request)
    {
        //入力値取得
        $product_code = $request->input('product_code');
        $input_count = $request->input('count');

        //購入数チェック
        if (ProductService::checkCount($input_count)) {
            //MSG007を出力
            $message = config('const.message.MSG007');
            return redirect()->route('product.detail', ['product_code' => $product_code])->with('message', $message)->withInput(['count' => $input_count]);
        }

        //在庫チェック
        if (ProductService::checkStock($product_code, $input_count)) {
            //MSG008を出力
            $message = config('const.message.MSG008');
            return redirect()->route('product.detail', ['product_code' => $product_code])->with('message', $message)->withInput(['count' => $input_count]);
        }

        //カートに追加
        ProductService::addProduct($product_code, $input_count);

        //かご画面へ
        return redirect()->route('cart.index');
    }

    /**
     * 戻る（商品詳細/商品登録結果画面）
     */
    public function back()
    {
        //前回の検索内容/ページ数を再表示
        if (session()->has('search_form')) {
            $search_form = session('search_form');
            return redirect()->route('product.search', $search_form);
        }
        return redirect()->route('product.index');
    }
}
