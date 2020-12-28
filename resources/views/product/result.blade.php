@extends('common.layout')

@section('content')
以下の商品をお買い物かごに登録しました。</br>
●商品一覧</br>

<table class="mx-auto" border="1">
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
    @endforeach
</table>
</br>

<button class="btn btn-secondary" type="button" onclick="location.href='{{route("cart.index")}}'">お買い物かご</button>
<button class="btn btn-secondary" type="button" onclick="location.href='{{route("product.back")}}'">戻る</button>
@endsection