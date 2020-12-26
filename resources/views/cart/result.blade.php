@extends('common.layout')

@section('content')

<label>{{config('const.message.MSG011')}}</label></br>
<button type="button" onclick="location.href='{{route("menu.user")}}'">メニューへ</button>
@endsection