@extends('includes.template')

@section('content')
    <div class="container">
        <h1>Оформление заказа</h1>

        <table class="table">
            <thead>
            <tr>
                <th>Товар</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Итого</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item->product->title }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->product->price }}</td>
                    <td>{{ $item->quantity * $item->product->price }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Итого</td>
                <td>{{ $cartItems->sum(function ($item) { return $item->quantity * $item->product->price; }) }}</td>
            </tr>
            </tbody>
        </table>

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="deliveryAddress">Адрес доставки</label>
                <input type="text" class="form-control" id="deliveryAddress" name="delivery_address" placeholder="Введите адрес доставки">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#mapModal">Выбрать на карте</button>
            </div>
            <button type="submit" class="btn btn-primary">Оформить заказ</button>
        </form>
    </div>
    <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">Выберите адрес на карте</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="map" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Вставьте этот код перед закрывающим тегом </body> -->
    <script src="https://api-maps.yandex.ru/2.1/?apikey=4a122e1f-50f1-42fa-8b33-50818d5dfdee&lang=ru_RU" type="text/javascript"></script>
    <script>
        ymaps.ready(init);

        function init() {
            var myMap = new ymaps.Map('map', {
                center: [55.76, 37.64], // Координаты центра карты по умолчанию
                zoom: 7
            });

            // Обработчик клика по карте
            myMap.events.add('click', function(e) {
                var coords = e.get('coords'); // Получаем координаты места, на которое был совершен клик
                ymaps.geocode(coords).then(function (res) { // Делаем обратное геокодирование для получения адреса
                    var firstGeoObject = res.geoObjects.get(0); // Получаем первый найденный геообъект
                    var address = firstGeoObject.getAddressLine(); // Получаем адрес этого геообъекта
                    document.getElementById('deliveryAddress').value = address; // Заполняем поле для адреса
                });
            });
        }
    </script>
@endsection
