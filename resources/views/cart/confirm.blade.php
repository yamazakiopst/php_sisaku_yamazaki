@extends('common.layout')

@section('content')
●商品一覧</br>

@if(session()->has('message'))
<!-- 取り扱い不可 -->
<label>{{session('message')}}</label></br>
@endif

<?php $total = 0; ?>
<table border="1">
    <tr>
        <td>商品コード</td>
        <td>商品名</td>
        <td>販売元</td>
        <td>価格</td>
        <td>購入数</td>
    </tr>
    @foreach($products as $product)
    <tr>
        <td>{{$product['code']}}</td>
        <td>{{$product['name']}}</td>
        <td>{{$product['maker']}}</td>
        <td align="right">&yen;{{number_format($product['price'])}}</td>
        <td>{{$product['count']}}</td>
    </tr>
    <?php $total += $product['price'] * $product['count'] ?>
    @endforeach
</table>

●料金</br>
<?php $tax = floor($total / 10); ?>
<table border="1">
    <tr>
        <td>小計</td>
        <td align="right">&yen;{{$total}}</td>
    </tr>
    <tr>
        <td>消費税</td>
        <td align="right">&yen;{{$tax}}</td>
    </tr>
    <tr>
        <td>合計金額</td>
        <td align="right">&yen;{{$total + $tax}}</td>
    </tr>
</table>

<form method="POST" action="{{route('cart.order')}}">
    @csrf
    <input type="hidden" name="total_money" value="{{$total}}">
    <input type="hidden" name="total_tax" value="{{$tax}}">

    <input type="submit" name="forget" value="買い物をやめる">
    <input type="submit" name="order" value="注文する">
    <button type="button" onclick="location.href='{{route("cart.index")}}'">戻る</button>
</form>
@endsection