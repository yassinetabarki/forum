<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        window.App ={!! json_encode([
            'csrfToken'=> csrf_token(),
            'signedIn' => Auth::check(),
            'user'=> Auth::user()
        ])!!};
    </script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <!-- Styles -->
{{--    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">--}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <style>
        body{
            padding-bottom: 100px;
        }
        .level{
            display:flex; align-items: center;
        }
        .flex{
            flex:1;
        }
        .mr-1{
            margin-right: 1em;
        }
        [v-cloak] {display: none;}
    </style>
</head>
<body>
    <div id="app">
        @include('layouts.nav')
        <main class="py-4">
            @yield('content')
            <flash message="{{session('flash')}}"></flash>
        </main>
    </div>
</body>
</html>
