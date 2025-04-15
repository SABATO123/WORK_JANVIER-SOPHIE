<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BusCab - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <div>
                        <a href="/" class="flex items-center py-4">
                            <span class="font-semibold text-gray-500 text-lg">BusCab</span>
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    @guest
                        <a href="{{ route('login') }}" class="py-2 px-4 text-gray-500 hover:text-gray-700">Login</a>
                        <a href="{{ route('register') }}" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600">Register</a>
                    @else
                        <span class="text-gray-500">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="py-2 px-4 text-gray-500 hover:text-gray-700">Logout</button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="max-w-6xl mx-auto px-4">
            @yield('content')
        </div>
    </main>
    @stack('scripts')
</body>
</html>
