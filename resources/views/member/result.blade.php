@extends('common.layout')

@section('content')

@if(session()->has('member_no'))
<!-- 採番した会員番号表示 -->
<label>{{str_replace('${member_no}', session('member_no'), config('const.message.MSG001'))}}</label></br>
@endif
<button type="button" onclick="location.href='{{route("menu.user")}}'">メニューへ</button>
@endsection