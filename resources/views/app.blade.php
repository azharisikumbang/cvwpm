<!-- resources/views/app.blade.php -->

<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="global" class="bg-gray-100">
    <div class="flex">
        @include('components.sidebar')

        <div id="main" class="relative w-full h-full overflow-y-auto lg:ml-64 ml:0 transition-all">
            @include('components.top-navbar')

            @yield('breadcrumb')

            <div class="p-4 bg-white m-4 shadow rounded-lg">
                @yield('content')
            </div>
        </div>

    </div>

    <div class="bg-red-200 bg-green-200 bg-yellow-200" style="display:none"></div>
    @yield('script')

</body>

</html>