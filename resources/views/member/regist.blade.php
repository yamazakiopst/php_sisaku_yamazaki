@extends('common.layout')

@section('content')
<label>{{$message}}</label></br>
<button type="button" onclick="location.href='{{route("menu.user")}}'">メニューへ</button>
@endsection