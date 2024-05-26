<div id="mapDelivery" class="hidden fixed inset-0 bg-black bg-opacity-80 justify-center items-center z-50">
    <div
        class="bg-white rounded-lg shadow-lg w-full max-w-4xl transform translate-x-[-50%] translate-y-[-50%] relative left-1/2 top-1/2 flex">
        <div class="w-1/2 p-8 flex flex-col">
            <form method="post" action="{{ route('address.add') }}" class="">
                @csrf
                <div class="flex flex-col mb-4">
                    <label for="deliveryAddress" class="block text-gray-700 text-sm font-bold mb-2">Адрес
                        доставки</label>
                    <input type="text" class="input-custom" id="deliveryAddress" name="address"
                           placeholder="Введите адрес доставки">
                </div>
                <div class="flex gap-3">
                    <div class="mb-4">
                        <label for="entrance" class="block text-gray-700 text-sm font-bold mb-2">Подъезд</label>
                        <input type="text" class="input-custom" id="entrance" name="entrance"
                               placeholder="Введите подъезд">
                    </div>
                    <div class="mb-4">
                        <label for="intercom_code" class="block text-gray-700 text-sm font-bold mb-2">Код
                            домофона</label>
                        <input type="text" class="input-custom" id="intercom_code" name="intercom_code"
                               placeholder="Введите код домофона">
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="mb-4">
                        <label for="floor" class="block text-gray-700 text-sm font-bold mb-2">Этаж</label>
                        <input type="text" class="input-custom" id="floor" name="floor"
                               placeholder="Введите этаж">
                    </div>
                    <div class="mb-4">
                        <label for="apartment" class="block text-gray-700 text-sm font-bold mb-2">Номер квартиры</label>
                        <input type="text" class="input-custom" id="apartment" name="apartment"
                               placeholder="Введите номер квартиры">
                    </div>
                </div>
                <div class="flex flex-col mb-4">
                    <label for="comments" class="block text-gray-700 text-sm font-bold mb-2">Комментарий к
                        заказу</label>
                    <textarea type="text" class="input-custom" id="comments" name="comments"
                              placeholder="Введите описание продукта"></textarea>
                </div>
                <div class="w-full">
                    <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl focus:outline-none focus:shadow-outline">
                        Добавить
                    </button>
                </div>
            </form>
        </div>
        <div class="w-1/2 rounded-xl" id="mapModal">
            <div id="YandexMap" style="" class="w-full min-h-96 h-full rounded-r-lg"></div>
        </div>
        <div class="absolute right-[-10px] top-[-10px]">
            <button type="submit" class="bg-red-600 rounded-full p-0.5 hover:transform scale-100">
                <img src="{{ asset('img/delete.svg') }}" id="closeMap" alt=""></button>
        </div>

    </div>
</div>
<script src="https://api-maps.yandex.ru/2.1/?apikey=4a122e1f-50f1-42fa-8b33-50818d5dfdee&lang=ru_RU"
        type="text/javascript"></script>
<script>
    ymaps.ready(init);

    function init() {
        let myMap = new ymaps.Map('YandexMap', {
            center: [55.796123, 49.106519],
            zoom: 11
        });
        myMap.controls.remove('searchControl');
        myMap.controls.remove('typeControl');
        myMap.controls.remove('trafficControl');
        myMap.controls.remove('rulerControl');
        myMap.controls.remove('fullscreenControl');
        myMap.controls.remove('geolocateControl');
        myMap.controls.remove('buttons');
        myMap.options.set('scaleLine.visible', false);
        myMap.options.set('yandexLogo.visible', false);
        myMap.options.set('copyrights.visible', false);
        myMap.options.set('balloons.visible', false);
        myMap.options.set('search.suggest', false);
        let currentPlacemark = null;
        let addressPrefix = "Республика Татарстан, Казань, ";
        myMap.events.add('click', function (e) {
            let coords = e.get('coords');
            if (currentPlacemark) {
                myMap.geoObjects.remove(currentPlacemark);
            }
            currentPlacemark = new ymaps.Placemark(coords, {}, {
                draggable: true
            });
            currentPlacemark.events.add('dragend', function (e) {
                let coords = currentPlacemark.geometry.getCoordinates();
                ymaps.geocode(coords).then(function (res) {
                    let firstGeoObject = res.geoObjects.get(0);
                    let addressLine = firstGeoObject.getAddressLine();
                    if (addressLine.startsWith(addressPrefix)) {
                        addressLine = addressLine.substring(addressPrefix.length);
                    }
                    document.getElementById('deliveryAddress').value = addressLine;
                });
            });
            myMap.geoObjects.add(currentPlacemark);
            ymaps.geocode(coords).then(function (res) {
                let firstGeoObject = res.geoObjects.get(0);
                let addressLine = firstGeoObject.getAddressLine();
                if (addressLine.startsWith(addressPrefix)) {
                    addressLine = addressLine.substring(addressPrefix.length);
                }
                document.getElementById('deliveryAddress').value = addressLine;
            });
        });
    }
</script>
