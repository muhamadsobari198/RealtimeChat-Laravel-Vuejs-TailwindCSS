<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-blue-50 flex items-center justify-center min-h-screen">
    <div class="bg-white border flex rounded-lg shadow-lg overflow-hidden max-w-4xl w-full">
        <div class="w-1/2 p-8">
            <div class="mb-8">
                <i class="fas fa-comments text-blue-500 text-2xl"></i>
                <span class="text-2xl font-bold text-blue-600 ml-2">ChatApp <small class="text-sm font-normal">by Muhamad Sobari</small></span>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Log in</h2>
            <form method="POST" action="{{ route('login') }}"  novalidate>
                        @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email Address</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border border-red @enderror" id="email" placeholder="Input your email" type="email"  name="email"  value="{{ old('email') }}" required autocomplete="off"/>

                    @error('email')
                        <span class="text-sm text-red-500 mt-1" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline  @error('password')  border border-red  @enderror" id="password" placeholder="Enter your password" type="password" value="{{ old('password') }}" required autocomplete="off" name="password" />
                    <!-- <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">Forgot Password?</a> -->
                    @error('password')
                                    <span class="text-sm text-red-500" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Log In</button>
                </div>
            </form>
            <p class="mt-6 text-center text-gray-600 text-sm">
                Don't have an account?
               
                @if (Route::has('register'))
                <a class="text-blue-500 hover:text-blue-800" href="{{ route('register') }}">Sign up</a>
                @endif
            </p>
        </div>
        <div class="w-1/2 bg-blue-100 flex items-center justify-center">
            <i class="fas fa-comments text-blue-500 text-9xl"></i>
        </div>
    </div>
</body>
</html>