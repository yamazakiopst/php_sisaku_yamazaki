@extends('common.layout')

@section('content')
●商品説明</br>

@if(session()->has('message'))
<!-- 購入数エラー -->
<label>{{session('message')}}</label></br>
@endif

<form method="POST" action="{{route('product.detail.add')}}">
    @csrf
    <table border="1">
        <tr>
            <td>商品名</td>
            <td>「{{$product['product_name']}}」</td>
        </tr>
        <tr>
            <td>画像</td>
            <td><img src="{{$product['picture']}}"></td>
        </tr>
        <tr>
            <td>商品説明</td>
            <td style="width:20em;">{{$product['memo']}}</td>
        </tr>
        <tr>
            <td>価格</td>
            <td align="right">&yen;{{number_format($product['price'])}}</td>
        </tr>
        <tr>
            <td>購入数</td>
            <td><input type="text" name="count" value="{{old('count')}}">個</td>
        </tr>
    </table>

    <input type="hidden" name="product_code" value="{{$product['product_code']}}">

    <input type="submit" value="お買い物かごに入れる">
    <button type="button" onclick="location.href='{{route("product.back")}}'">戻る</button>
</form>
@endsection