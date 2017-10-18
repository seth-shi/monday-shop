<!doctype html>
<html lang="en">
<head>
    @include('layouts.admin.meta')

    <title>@yield('title', 'MondayShop')</title>
    @yield('style')
</head>
<body>
    @include('layouts.admin.header')

    @yield('main')


    @include('layouts.admin.footer')
    <!-- 此处 footer 仅是 引入js -->
    @include('layouts.admin.js')
    @yield('script')
</body>
</html>




