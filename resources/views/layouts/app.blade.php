<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Chat App') }}</title>

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
        <a class="" href="{{url('/')}}">
                <i class="fas fa-comments text-blue-500 text-2xl"></i>
                <span class="text-2xl font-bold text-blue-600 ml-2">ChatApp</span>
            </a>
        <div class="flex items-center space-x-4">
        <div class="flex items-center gap-4" >
                                    <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="User Avatar" onerror="this.src='https://icons.iconarchive.com/icons/papirus-team/papirus-status/512/avatar-default-icon.png'" class="rounded-full object-cover rounded-full h-[30px] w-[30px]">

                                <span class="capitalize text-sm">
                                    {{ Auth::user()->name }}
                                </span>
                                </div>
            <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                         <i class="fas fa-sign-out-alt text-red-600"></i>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>           
        </div>
    </header>

        <main class="main">
            @yield('content')
        </main>

        <!-- <div id="app"></div> -->

        
</body>
</html>
