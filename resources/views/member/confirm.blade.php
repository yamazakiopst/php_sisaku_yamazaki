@extends('common.layout')

@section('content')
この内容で登録しますか？</br>
●会員情報</br>

<form method="POST" action="{{route('member.regist')}}">
    @csrf
    <table class="mx-auto" border="1">
        <tr>
            <td>氏名</td>
            <td>{{$form['name']}}</td>
        </tr>
        <tr>
            <td>年齢</td>
            <td>{{$form['age']}}</td>
        </tr>
        <tr>
            <td>性別</td>
            <td>@if ($form['sex'] === '0') 男性
                @elseif ($form['sex'] === '1') 女性
                @endif</td>
        </tr>
        <tr>
            <td>郵便番号</td>
            <td>{{$form['zip']}}</td>
        </tr>
        <tr>
            <td>住所</td>
            <td>{{$form['address']}}</td>
        </tr>
        <tr>
            <td>電話番号</td>
            <td>{{$form['tel']}}</td>
        </tr>
    </table>
    </br>

    <input type="hidden" name="name" value="{{$form['name']}}">
    <input type="hidden" name="password" value="{{$form['password']}}">
    <input type="hidden" name="age" value="{{$form['age']}}">
    <input type="hidden" name="sex" value="{{$form['sex']}}">
    <input type="hidden" name="zip" value="{{$form['zip']}}">
    <input type="hidden" name="address" value="{{$form['address']}}">
    <input type="hidden" name="tel" value="{{$form['tel']}}">

    <input class="btn btn-secondary" type="submit" name="confirm" value="登録">
    <input class="btn btn-secondary" type="submit" name="back" value="戻る">
</form>
@endsection