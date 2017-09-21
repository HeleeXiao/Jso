<!DOCTYPE html>
<html lang="en">
<head>
    @include('web.default.head')
</head>
<body>
    @include('web.default.header')
    @yield('content')
    @include('web.default.footer')
    @include('web.default.foot')
</body>
</html>