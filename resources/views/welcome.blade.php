<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>入居管理</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>
            @if (Route::has('login'))
            <div class="flex items-center justify-end mt-4">
                    @auth
                    <form action="{{ route('/dashboard') }}">
                        <x-primary-button>{{ __('ダッシュボード') }}</x-primary-button>
                    </form>
                    @else
                        <form action="{{ route('login') }}">
                            <x-primary-button>{{ __('ログイン') }}</x-primary-button>
                        </form>
                        &emsp;
                        @if (Route::has('register'))
                        <form action="{{ route('register') }}">
                            <x-primary-button>{{ __('新規登録') }}</x-primary-button>
                        </form>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </body>
</html>











