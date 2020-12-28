@extends('common.layout')

@section('content')
会員情報を入力してください。</br>
●会員情報</br>

@if ($errors->any())
<!-- 入力エラー -->
@foreach ($errors->all() as $error)
<label>{{$error}}</label></br>
@endforeach
@endif

<form method="POST" action="{{route('member.confirm')}}">
    @csrf
    <table class="mx-auto" border="1">
        <tr>
            <td>氏名</td>
            <td><input type="text" name="name" value="{{old('name')}}"></td>
        </tr>
        <tr>
            <td>パスワード</td>
            <td><input type="password" name="password1" value="{{old('password1')}}"></td>
        </tr>
        <tr>
            <td>パスワード</br>（確認用）</td>
            <td><input type="password" name="password2" value="{{old('password2')}}"></td>
        </tr>
        <tr>
            <td>年齢</td>
            <td><input type="text" name="age" value="{{old('age')}}"></td>
        </tr>
        <tr>
            <td>性別</td>
            <td class="text-left">
                <select name="sex">
                    <option value="0" @if (old('sex')==='0' ) selected @endif>男性</option>
                    <option value="1" @if (old('sex')==='1' ) selected @endif>女性</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>郵便番号</td>
            <td><input type="text" name="zip" value="{{old('zip')}}"></td>
        </tr>
        <tr>
            <td>住所</td>
            <td><textarea name="address">{{old('address')}}</textarea></td>
        </tr>
        <tr>
            <td>電話番号</td>
            <td><input type="text" name="tel" value="{{old('tel')}}"></td>
        </tr>
    </table>
    </br>

    <input class="btn btn-secondary" type="submit" value="確認">
    <button class="btn btn-secondary" type="button" onclick="location.href='{{route("menu.user")}}'">戻る</button>
    <button class="btn btn-secondary" type="button" onclick="location.href='{{route("member.index")}}'">クリア</button>
</form>
@endsection