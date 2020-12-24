@extends('common.layout')

@section('content')

<label>{{str_replace('${member_no}', $member_no, config('const.message.MSG001'))}}</label></br>
<button type="button" onclick="location.href='{{route("menu.user")}}'">メニューへ</button>
@endsection