@extends('common.layout')

@section('content')
●商品一覧</br>

@if(session()->has('message'))
<!-- 未選択 -->
<label>{{session('message')}}</label></br>
@endif

<form method="POST" action="{{route('cart.operate')}}">
    @csrf
    <table border="1">
        <tr>
            <td>選択</td>
            <td>商品コード</td>
            <td>商品名</td>
            <td>販売元</td>
            <td>価格</td>
            <td>購入数</td>
        </tr>
        @foreach($products as $product)
        <tr>
            <td><input type="checkbox" name="product_code[]" value="{{$product['code']}}"></td>
            <td>{{$product['code']}}</td>
            <td>{{$product['name']}}</td>
            <td>{{$product['maker']}}</td>
            <td align="right">&yen;{{number_format($product['price'])}}</td>
            <td><input type="text" name="count[]" value="{{old('count.'.$loop->index,$product['count'])}}"></td>
        </tr>
        @endforeach
    </table>

    <input type="submit" name="delete" value="取り消し">
    <input type="submit" name="forget" value="買い物をやめる">
    <input type="submit" name="order" value="注文する">
    <button type="button" onclick="location.href='{{route("menu.user")}}'">メニューへ</button>
</form>
@endsection