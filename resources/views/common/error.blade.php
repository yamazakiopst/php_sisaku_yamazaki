@extends('common.layout')

@section('content')
<label>予期せぬエラーが発生しました。管理者にお問い合わせください</label></br>
<button type="button" onclick="location.href='{{route("menu.user")}}'">メニューへ</button>
@endsection