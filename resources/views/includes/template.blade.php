<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/img/loog.svg') }}" style="width: 100%;" type="image/x-icon">
    <title>@yield('title', config('app.name'))</title>
    @yield('head')
    @vite('resources/css/app.css')
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}" defer></script>
    {{--    <script src="https://api-maps.yandex.ru/2.1/?apikey=4a122e1f-50f1-42fa-8b33-50818d5dfdee&lang=ru_RU" type="text/javascript"></script>--}}
    {{--    <script>--}}
    {{--        ymaps.ready(init);--}}

    {{--        function init() {--}}
    {{--            var myMap = new ymaps.Map("map", {--}}
    {{--                center: [55.76, 37.64], --}}
    {{--                zoom: 7--}}
    {{--            });--}}

    {{--            var suggestView = new ymaps.SuggestView('deliveryAddress');--}}

    {{--            suggestView.events.add('select', function(e) {--}}
    {{--                var address = e.get('item').value;--}}
    {{--                document.getElementById('deliveryAddress').value = address;--}}
    {{--                $('#mapModal').modal('hide'); // Закрываем модальное окно--}}
    {{--            });--}}
    {{--        }--}}
    {{--    </script>--}}
</head>
<body>
@include('includes.header')
@include('includes.message')
@yield('content')
@include('includes.footer')
</body>
</html>
