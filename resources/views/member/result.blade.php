@extends('common.layout')

@section('content')
@if(session()->has('message'))
<!-- 採番した会員番号表示 -->
<label>{{session('message')}}</label></br>
@endif
<button type="button" onclick="location.href='{{route("menu.user")}}'">メニューへ</button>
@endsection