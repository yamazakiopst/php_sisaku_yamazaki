@extends('common.layout')

@section('content')

@if(session()->has('order_complete_flag'))
<!-- 注文完了 -->
<label>{{config('const.message.MSG011')}}</label></br>
@endif
<button type="button" onclick="location.href='{{route("menu.user")}}'">メニューへ</button>
@endsection