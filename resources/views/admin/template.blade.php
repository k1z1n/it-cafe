<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'admin panel')</title>
    @yield('head')
    @vite('resources/css/app.css')
</head>
<body>
@include('includes.admin-header')
@yield('content')
</body>
</html>
