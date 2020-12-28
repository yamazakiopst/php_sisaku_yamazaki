@extends('common.layout')

@section('content')

<table class="mx-auto bg-warning">
    @if (!session()->has('login_user'))
    <!--未ログイン時のみ表示-->
    <tr>
        <td><a href="{{route('member.index')}}">新規会員登録</a></td>
        <td>会員情報の登録を行います。</td>
    </tr>
    @endif
    <tr>
        <td><a href="">会員情報変更・削除</a></td>
        <td>会員情報の変更、削除を行います。</td>
    </tr>
    <tr>
        <td><a href="{{route('product.index')}}">商品検索</a></td>
        <td> 購入する商品の検索を行います。</td>
    </tr>
    <tr>
        <td><a href="{{route('cart.index')}}">お買い物かご</a></td>
        <td>商品の注文を行います。</td>
    </tr>
</table>

<div class="text-center">
    @if (session()->has('login_user'))
    <!--ログイン時のみ表示-->
    <button type="button" onclick="location.href='{{route("logout")}}'">ログアウト</button>
    @else
    <!--未ログイン時のみ表示-->
    <button class="text-center" type="button" onclick="location.href='{{route("login.index")}}'">ログイン</button>
    @endif
</div>
@endsection