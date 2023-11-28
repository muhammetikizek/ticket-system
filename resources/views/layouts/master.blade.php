<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bilet Satış Paneli</title>
    @vite('resources/css/app.css')
</head>

<body>
    @include('layouts.navigation')
    <div class="container-fluid" id="app">
        @hasSection('title')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-white my-auto">
                @yield('title')
            </h1>
            @if(session()->has('success'))
            <span class="text-white">
                <u class="fw-bold">{{ session('switchedStore') }},</u>
                {{ session('success') }}
            </span>
            @endif
            <div>
                @yield('actions')
            </div>
        </div>
        @endif
        @hasSection('content')
        @yield('content')
        @endif
    </div>
    @vite('resources/js/app.js')
</body>

</html>
