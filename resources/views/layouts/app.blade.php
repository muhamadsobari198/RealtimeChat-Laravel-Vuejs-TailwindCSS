<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

    <link rel="shortcut icon" href="storage/favicon.ico" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        /* .navbar-brand, .nav-link{
font-family: system-ui;
    font-weight: bold;
    letter-spacing: 0px;
} */
.test{
    border:1px solid red;
}
    </style>
</head>
<body>
    
  <!-- Header -->
  <header class="flex items-center justify-between bg-white p-4 shadow mb-1">
        <h1 class="text-xl font-bold">Chat App</h1>
        <div class="flex items-center space-x-4">
            <i class="fas fa-moon text-gray-600 cursor-pointer" id="dark-mode-toggle"></i>
            <i class="fas fa-sync-alt text-gray-600"></i>
            <i class="fas fa-robot text-blue-600"></i>
        </div>
    </header>

        <main class="main">
            @yield('content')
        </main>

        <!-- <div id="app"></div> -->

        
</body>
</html>
