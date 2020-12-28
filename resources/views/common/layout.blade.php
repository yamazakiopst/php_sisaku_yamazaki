<!doctype html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>

<body>
    <!-- 共通ヘッダー -->
    <div class="border-bottom border-dark">
        オンラインショッピングサイト
        <div class="float-right">
            {{\Carbon\Carbon::now()->format('Y年m月d日 H:i')}}
            @if(session()->has('login_user'))
            <!--ログイン済み -->
            「{{session('login_user')['user_name']}}」
            @else
            <!-- 未ログイン -->
            「ゲストさん」
            @endif
        </div>
    </div>

    @yield('content')
</body>

</html>