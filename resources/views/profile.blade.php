@extends('includes.template')
@section('head')
    <script src="{{ asset('js/update-profile.js') }}" defer></script>
@endsection
@section('content')
    @include('update-profile')
    <div class="container">
        <div class="flex gap-5 mt-5">
            <div class="flex flex-col w-1/3">
                <div class="bg-white rounded-2xl shadow-custom px-4 py-5 flex flex-col relative">
                    <div class="absolute top-4 right-4 cursor-pointer" id="createUpdateProfile">
                        <img src="{{ asset('img/update-profile.svg') }}" alt="">
                    </div>
                    <div class="flex justify-center items-center mb-4">
                        <div class="bg-blue-600 w-16 h-16 rounded-full flex justify-center items-center">
                        </div>
                    </div>
                    <div class="text-center font-bold text-xl">Ваш профиль</div>
                    <div class="flex flex-row mt-4 items-center justify-between">
                        <div class="text-gray-500">Имя</div>
                        @if($user->username)
                            <div class="text-gray-700">{{ $user->username }}</div>
                        @else
                            <div class="text-gray-700">Имя не указано</div>
                        @endif
                    </div>
                    <div class="flex flex-row mt-2 items-center justify-between">
                        <div class="text-gray-500">Телефон</div>
                        <div class="text-gray-700">+7{{ $user->phone_number }}</div>
                    </div>
                    <div class="flex flex-row mt-2 items-center justify-between">
                        <div class="text-gray-500">Email</div>
                        @if($user->email)
                            <div class="text-gray-700">{{ $user->email }}</div>
                        @else
                            <div class="text-gray-700">Email не указан</div>
                        @endif
                    </div>
                    <div class="flex flex-row mt-2 items-center justify-between">
                        <div class="text-gray-500">Дата рождения</div>
                        @if($user->date)
                            <div class="text-gray-700">{{$user->date}}</div>
                        @else
                            <div class="text-gray-700">Дата не указана</div>
                        @endif
                    </div>
                </div>
                <div class="mt-4">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="py-2 px-8 bg-blue-900 rounded-xl text-white">Выйти</button>
                    </form>
                </div>
            </div>
            <div class="flex flex-col w-2/3 gap-4 mb-12">
                <div class="shadow-custom px-4 py-3.5 bg-white rounded-2xl">
                    <div class="text-xl">Ваши баллы: <span class="text-blue-900 font-semibold">{{ auth()->user()->scores }} Б</span>
                    </div>
                </div>
                <div class="shadow-custom px-4 py-3.5 bg-white rounded-2xl">
                    <div class="font-bold text-xl w-full border-b border-[#B1B2B2] pb-2">История заказов</div>
                    <div>
                        @if(count($orders)>0)
                            @foreach($orders as $order)
                                <div class="profile-orders-block pt-2 pb-2 mt-3">
                                    <div class="orders-title-info flex justify-between w-full">
                                        <div class="flex gap-4">
                                            <p><span class="text-gray-500">Итог:</span> {{ $order->total }} ₽</p>
                                            @php
                                                $bonus = (int)round($order->total / 100);
                                            @endphp
                                            <p class="text-blue-900 font-semibold">+ {{ $bonus }} Б</p>
                                        </div>
                                        <p class=""><span
                                                    class="text-gray-500">Дата заказа:</span> {{ $order->created_at->translatedFormat('d F') }}
                                        </p>
                                    </div>
                                    <div class="flex flex-col gap-4 mt-4">
                                        @foreach($order->orderItems as $item)
                                            <div class="grid grid-cols-3 gap-5 items-center">
                                                <div class="flex justify-start gap-5 items-center"><img
                                                            src="{{ asset('storage/imgss/'.$item->product->image_path) }}" alt=""
                                                            class="w-14"><p>{{ $item->product->title }}</p></div>
                                                <div class="flex justify-start"><p>{{ $item->quantity }} шт.</p></div>
                                                <div class="flex justify-start">
                                                    <p>{{ $item->product->price*$item->quantity  }} ₽</p></div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div>История пуста</div>
                        @endif
                    </div>
                </div>
                <div class="shadow-custom px-4 py-3.5 bg-white rounded-2xl">
                    <div class="font-bold text-xl w-full border-b border-[#B1B2B2] pb-2">Адреса доставки</div>
                    <div class="">
                        @if(count($addresses)>0)
                            <div class="flex justify-between items-center mt-3">
                                @foreach($addresses as $add)
                                    <div class="font-normal text-lg">{{$add->address}}</div>
                                    <div class="flex gap-1 text-xs">
                                        <p>Редактивароть</p>
                                        <p>Удалить</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-blue-600 cursor-pointer" id="createMap">Добавить адрес +</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--<div class="card">--}}
{{--    <div class="card-header bg-primary text-white">--}}
{{--        <h3 class="card-title mb-0">Профиль пользователя</h3>--}}
{{--    </div>--}}
{{--    <div class="card-body">--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-6 box-shadow" style="background-color: white">--}}
{{--                <h4>Личная информация</h4>--}}
{{--                <p><strong>Имя:</strong> {{ $user->username }}</p>--}}
{{--                <p><strong>Email:</strong> {{ $user->email }}</p>--}}
{{--                <a href="{{ route('logout') }}"><strong>Выйти</strong> <img src="{{ asset('img/out.svg') }}" alt=""></a>--}}
{{--            </div>--}}
{{--            <div class="col-md-6">--}}
{{--                <h4>История заказов</h4>--}}
{{--                @if($orders->count() > 0)--}}
{{--                    @foreach($orders as $order)--}}
{{--                        <div class="card mb-3">--}}
{{--                            <div class="card-header bg-light">--}}
{{--                                Заказ №{{ $order->id }} от {{ $order->created_at->format('d.m.Y H:i') }}--}}
{{--                                <span class="float-right">Сумма: {{ $order->total }}</span>--}}
{{--                            </div>--}}
{{--                            <div class="card-body">--}}
{{--                                <h5 class="card-title">Состав заказа:</h5>--}}
{{--                                <ul class="list-group list-group-flush">--}}
{{--                                    @foreach($order->orderItems as $item)--}}
{{--                                        <li class="list-group-item">--}}
{{--                                            <img src="{{ asset('images/' . $item->product->image) }}" alt="">--}}
{{--                                            {{ $item->product->title }} x {{ $item->quantity }}--}}
{{--                                            <span class="float-right">{{ $item->price * $item->quantity }}</span>--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                                <h6 class="card-title">Статус заказа:</h6>--}}
{{--                                <ul class="list-group list-group-flush">--}}
{{--                                    <li class="list-group-item">--}}
{{--                                        {{ $order->status }}--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                @else--}}
{{--                    <p>У вас пока нет заказов.</p>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
