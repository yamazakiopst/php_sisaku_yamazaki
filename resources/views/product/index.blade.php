@extends('common.layout')

@section('content')
検索条件を入力してください。</br>

@if ($errors->any())
<!-- 入力エラー -->
@foreach ($errors->all() as $error)
<label>{{$error}}</label></br>
@endforeach
@endif

@if(isset($message))
<!-- 検索結果0件 -->
<label>{{$message}}</label></br>
@endif

@if(session()->has('message'))
<!-- 未選択/未入力 -->
<label>{{session('message')}}</label></br>
@endif

<form method="GET" action="{{route('product.search')}}">
    <table border="1">
        <tr>
            <td>カテゴリ</td>
            <td><select name="category">
                    <option value="">全て</option>
                    @foreach($categories as $category)
                    <option value="{{$category->ctgr_id}}" @if (intval(old('category',isset($search_form)?$search_form['category']:''))===$category->ctgr_id) selected @endif>{{$category->name}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>商品名</td>
            <td><input type="text" name="product_name" value="{{old('product_name',isset($search_form)?$search_form['product_name']:'')}}"></td>
        </tr>
        <tr>
            <td>販売元</td>
            <td><input type="text" name="maker" value="{{old('maker',isset($search_form)?$search_form['maker']:'')}}"></td>
        </tr>
        <tr>
            <td>金額上限</td>
            <td><input type="text" name="max_price" value="{{old('max_price',isset($search_form)?$search_form['max_price']:'')}}"></td>
        </tr>
        <tr>
            <td>金額下限</td>
            <td><input type="text" name="min_price" value="{{old('min_price',isset($search_form)?$search_form['min_price']:'')}}"></td>
        </tr>
    </table>

    <input type="submit" value="検索">
    <button type="button" onclick="location.href='{{route("menu.user")}}'">戻る</button>
    <button type="button" onclick="location.href='{{route("product.index")}}'">クリア</button>
</form>

@if(isset($products))
<!-- 検索結果 -->
●商品一覧</br>
{{$products->appends(request()->input())->links('common/pagination')}}

<form method="POST" action="{{route('product.add')}}">
    @csrf
    <table border="1">
        <tr>
            <td>選択</td>
            <td>商品コード</td>
            <td>商品名</td>
            <td>販売元</td>
            <td>金額(単価)</td>
            <td>メモ</td>
            <td>購入数</td>
        </tr>
        <?php $select_index = 0; ?>
        @foreach($products as $product)
        <tr>
            <td><input type="checkbox" name="select[]" value="{{$loop->index}}" @if (intval(old('select.'.$select_index,100))===$loop->index) checked <?php $select_index++; ?>@endif></td>
            <td>{{$product->product_code}}</td>
            <td><a href="{{route('product.detail',['product_code'=>$product->product_code])}}">{{$product->product_name}}</a></td>
            <td>{{$product->maker}}</td>
            <td align="right">&yen;{{number_format($product->unit_price)}}</td>
            <td>
                @if (mb_strlen($product->memo) > 20)
                {{mb_substr($product->memo, 0, 20)}}・・・
                @else
                {{$product->memo}}
                @endif
            </td>
            <td><input type="text" name="count[]" value="{{old('count.'.$loop->index)}}"></td>
            <input type="hidden" name="product_code[]" value="{{$product->product_code}}">
        </tr>
        @endforeach
    </table>
    <input type="submit" value="お買い物かごに入れる">
</form>
@endif
@endsection