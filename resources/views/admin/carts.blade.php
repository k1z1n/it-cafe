@extends('admin.template')
@section('content')
    <div class="container mt-3">
        <div id="users" class="page">
            <h1 class="text-3xl font-bold my-6">Товары корзины</h1>
            @if(session('success'))
                <div class="text-green-600 my-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-container overflow-x-auto">
                <table class="table w-full border-collapse">
                    <thead class="bg-gray-200">
                    <tr class="text-center">
                        <th class="px-4 py-2 text-center">ID</th>
                        <th class="px-4 py-2 text-center">Имя</th>
                        <th class="px-4 py-2 text-center">Название продукта</th>
                        <th class="px-4 py-2 text-center">Количество продукта</th>
                        <th class="px-4 py-2 text-center">Цена продукта</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($carts as $cart)
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2 text-center">{{ $cart->id }}</td>
                            <td class="px-4 py-2 text-center">{{ $cart->user->phone_number }}</td>
                            <td class="px-4 py-2 text-center">{{ $cart->product->title }}</td>
                            <td class="px-4 py-2 text-center">{{ $cart->quantity }}</td>
                            <td class="px-4 py-2 text-center">{{ $cart->product->price }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
