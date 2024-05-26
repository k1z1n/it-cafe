@extends('includes.template')
@section('head')
    <script src="{{ asset('js/map.js') }}" defer></script>
@endsection
@section('content')
    @include('map.map')

    <div class="container">
        <h1 class="text-3xl font-bold mt-8 mb-6">Корзина</h1>

        @if($cartItems->isEmpty())
            <div class="flex flex-col items-center justify-center h-full">
                <p class="text-gray-600">Ваша корзина пуста.</p>
                <a href="{{ route('index') }}" class="py-2 mt-6 px-8 bg-blue-900 rounded-xl text-white">Вернуться на главную</a>
            </div>
        @else
            <div class="flex flex-col gap-5">
                @php $total = 0 @endphp
                @foreach($cartItems as $item)
                    @php $total += $item->quantity * $item->product->price @endphp
                    <div class="w-full flex relative shadow-custom bg-white p-4 rounded-2xl">
                        <div class="w-1/2 flex items-center gap-3">
                            <img src="{{ asset('storage/imgss/'.$item->product->image_path) }}" alt="" class="w-24 rounded-2xl">
                            <div class="flex flex-col items-start gap-2">
                                <p class="text-sm">{{ $item->product->title }}</p>
                                <p class="text-xs text-[#a3a3a3]"><span
                                        class="font-bold text-[#a3a3a3]">Состав: </span>{{ $item->product->structure }}
                                </p>
                            </div>
                        </div>
                        <div class="w-1/2 grid grid-cols-3">
                            <div
                                class="flex justify-center items-center text-xl text-green-600">{{$item->product->price}}
                                ₽
                            </div>
                            <div class="flex justify-center">
                                <form action="{{ route('cart.update', $item->id) }}" method="post"
                                      class="flex items-center">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="decrement"
                                            class="border-r-2 border-black border-opacity-5 bg-[#F9F9FB] p-2 rounded-l-md">
                                        -
                                    </button>
                                    <div
                                        class="text-[#A3A3A3] bg-[#F9F9FB] w-full py-2 px-5">{{ $item->quantity }}</div>
                                    <button type="submit" name="action" value="increment"
                                            class="border-l-2 border-black border-opacity-5 bg-[#F9F9FB] p-2 rounded-r-md">
                                        +
                                    </button>
                                </form>
                            </div>
                            <div class="flex justify-center items-center text-xl text-black">
                                {{ $item->quantity * $item->product->price }} ₽
                            </div>
                        </div>
                        <div class="absolute right-[-10px] top-[-10px]">
                            <form action="{{ route('cart.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 rounded-full p-0.5 hover:transform scale-100">
                                    <img src="{{ asset('img/delete.svg') }}" alt=""></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-full mt-5 flex gap-4 mb-12">
                <div class="w-1/3 shadow-custom px-4 py-3.5 bg-white rounded-2xl">
                    <div class="flex justify-between">
                        <div>Итого к оплате:</div>
                        <div id="totalPrice" class="font-semibold text-xl">{{ $total }} ₽</div>
                    </div>
                    <div>
                        <div class="text-xs my-2 text-gray-500">Можно оплатить баллами не более 30% заказа</div>
                        <div>Доступно для списания: <span id="availablePoints">{{ min(auth()->user()->scores, intval($total * 0.3)) }}</span> Б</div>
                    </div>
                    <div id="pointsValue" class="flex justify-end">0 Б</div>
                    <input type="range" id="pointsRange" min="0" max="{{ min(auth()->user()->scores, intval($total * 0.3)) }}" value="0" oninput="updatePointsValue()" class="w-full appearance-none h-2 rounded-lg bg-gray-200 cursor-pointer">
                    <div class="flex justify-between items-center mt-2">
                        <div class="w-12 text-sm">0</div>
                        <div class="w-12 text-sm text-right">{{ min(auth()->user()->scores, intval($total * 0.3)) }}</div>
                    </div>
                </div>

                <script>
                    // Сохраняем изначальную итоговую сумму заказа
                    const initialTotal = parseFloat(document.getElementById('totalPrice').innerText);

                    function updatePointsValue() {
                        const rangeInput = document.getElementById('pointsRange');
                        const currentValue = parseInt(rangeInput.value);
                        document.getElementById('pointsValue').innerText = currentValue + ' Б';
                        document.getElementById('total-bonus-order').value = currentValue
                        // Вычисляем остаток после списания баллов из изначальной итоговой суммы
                        const remainingPrice = initialTotal - currentValue;
                        document.getElementById('total-price-order').value = remainingPrice
                        document.getElementById('totalPrice').innerText = remainingPrice.toFixed(0) + ' ₽';
                    }
                </script>

                <div class="w-1/3 shadow-custom px-4 py-3.5 bg-white rounded-2xl max-h-64">
                    <div class="text-blue-600 cursor-pointer" id="createMap">Добавить адрес +</div>
                    <div class="max-h-[6.25rem] overflow-y-auto mt-4 h-full">
                        <div id="radioContainer" class="flex flex-col gap-2 h-full">
                            <form action="{{ route('address.update.active') }}" method="post" id="addressForm" class="flex flex-col gap-2">
                                @foreach($addresses as $add)
                                    @csrf
                                    <div
                                        class="flex w-full gap-4 border border-gray-300 rounded-xl py-2 px-3 focus:outline-none {{ $add->status === 'selected' ? 'border-blue-700' : '' }}">
                                        <input type="radio" name="address" class="address-radio" value="{{ $add->id }}"
                                               {{ $add->status === 'selected' ? 'checked' : '' }}
                                               id="{{ $add->id }}">
                                        <label for="{{ $add->id }}">{{ $add->address }}</label>
                                    </div>
                                @endforeach
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    // Получаем все радиокнопки
                    let radioButtons = document.querySelectorAll('.address-radio');

                    // Добавляем обработчик событий на изменение состояния каждой радиокнопки
                    radioButtons.forEach(function (radio) {
                        radio.addEventListener('change', function () {
                            // Отправляем форму
                            document.getElementById('addressForm').submit();
                        });
                    });
                </script>
                <div class="w-1/3 shadow-custom px-4 py-3.5 bg-white rounded-2xl">
                    <form action="{{ route('update.payment.method') }}" method="post"
                          class="flex items-center flex-col w-full gap-2">
                        @csrf
                        <label for="cash" id="cash-lab"
                               class="flex items-center cursor-pointer border p-2 rounded-xl w-full {{ auth()->user()->payment === 'cash' ? 'border-blue-500' : '' }}">
                            <input type="radio" id="cash" name="payment_method" value="cash" class="hidden"
                                   onchange="updatePaymentMethod('cash')" {{ auth()->user()->payment === 'cash' ? 'checked' : '' }}>
                            <span class="text-gray-700">Наличные</span>
                        </label>
                        <label for="card" id="card-lab"
                               class="flex items-center cursor-pointer border p-2 rounded-xl w-full {{ auth()->user()->payment === 'card' ? 'border-blue-500' : '' }}">
                            <input type="radio" id="card" name="payment_method" value="card" class="hidden"
                                   onchange="updatePaymentMethod('card')" {{ auth()->user()->payment === 'card' ? 'checked' : '' }}>
                            <span class="text-gray-700">Оплата картой</span>
                        </label>
                    </form>
                    @if(!$cartItems->isEmpty())
                        <form action="{{ route('orders.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="total-minus-bonus" value="" id="total-bonus-order">
                            <input type="hidden" name="total-price" value="" id="total-price-order">
                            <button type="submit" class="w-full py-2 mt-2 bg-[#219ebc] rounded-xl text-white">Оформить заказ</button>
                        </form>
                    @endif

                    <script>
                        let cash = document.getElementById('cash-lab')
                        let card = document.getElementById('card-lab')
                        cash.addEventListener('click', function () {
                            cash.classList.add('border-blue-500');
                            card.classList.remove('border-blue-500');
                        });

                        card.addEventListener('click', function () {
                            cash.classList.remove('border-blue-500');
                            card.classList.add('border-blue-500');
                        });

                        function updatePaymentMethod(method) {
                            fetch('/update-payment-method', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({method: method})
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Ошибка HTTP ' + response.status);
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    const cashLabel = document.querySelector('#cash');
                                    const cardLabel = document.querySelector('#card');
                                    cashLabel.classList.remove('border-blue-500');
                                    cardLabel.classList.remove('border-blue-500');
                                    if (data.method === 'cash') {
                                        cashLabel.classList.add('border-blue-500');
                                    } else if (data.method === 'card') {
                                        cardLabel.classList.add('border-blue-500');
                                    }
                                    // Установка выбранного значения в радио-кнопку
                                    const input = document.querySelector(`input[value="${data.method}"]`);
                                    if (input) {
                                        input.checked = true;
                                    }
                                })
                                .catch(error => console.error('Ошибка:', error));
                        }
                    </script>
                </div>
            </div>
        @endif
    </div>
@endsection
