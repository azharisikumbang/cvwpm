<!-- resources/views/app.blade.php -->

<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ config('app.name') }}</title>

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

    <div class="
        bg-red-100 bg-green-100 bg-yellow-100
        bg-red-200 bg-green-200 bg-yellow-200
        bg-red-500 bg-green-500 bg-yellow-500

        
        text-red-100 text-green-100 text-yellow-100
        text-red-200 text-green-200 text-yellow-200
    " style="display:none"></div>

    <div id="loader">
        <div></div>
    </div>
    @yield('script')
</body>

</html>