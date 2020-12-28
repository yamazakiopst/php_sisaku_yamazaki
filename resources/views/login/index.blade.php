@extends('common.layout')

@section('content')
<a href="{{route('member.index')}}">新規会員の方はこちら</a></br>

@if ($errors->any())
<!-- 入力エラー -->
@foreach ($errors->all() as $error)
<label>{{$error}}</label></br>
@endforeach
@endif

@if(session()->has('message'))
<!-- 認証失敗 -->
<label>{{session('message')}}</label></br>
@endif

<form method="POST" action="{{route('login.auth')}}">
    @csrf
    <table class="mx-auto" border="1">
        <tr>
            <td>会員NO</td>
            <td><input type="text" name="member_no"></td>
        </tr>
        <tr>
            <td>パスワード</td>
            <td><input type="password" name="password"></td>
        </tr>
    </table>
    </br>

    <input class="btn btn-secondary" type="submit" value="ログイン">
    <input class="btn btn-secondary" type="reset" value="クリア">
</form>
@endsection