@extends('common.layout')

@section('content')

<label>{{config('const.message.MSG011')}}</label></br>
<button class="btn btn-secondary" type="button" onclick="location.href='{{route("menu.user")}}'">メニューへ</button>
@endsection