@extends('admin.template')
@section('content')
    <div class="container mt-3">
        <div id="products" class="page">
            <h1 class="text-3xl font-bold my-6">Товары</h1>
            @if(session('success'))
                <div class="text-green-600 my-4">
                    {{ session('success') }}
                </div>
            @endif
            <form id="search-form" class="mb-3 flex gap-1.5 w-full" action="{{ route('admin.product.search') }}" method="get">
                <input type="text" id="search-input" name="search" placeholder="Поиск товаров..." required
                       class="border border-gray-300 px-3 py-2 rounded-md w-4/5 focus:outline-none focus:border-blue-500" value="{{ request()->input('search') }}">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 w-1/5 rounded-md ml-2 hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Найти</button>
            </form>
            @if(isset($count))
                @if($count > 0)
                    <div class="text-start mb-3 text-xl">По запросу "{{ request()->input('search') }}" найдено {{ $count }} записей</div>
                @else
                    <div class="text-center mb-3">По запросу "{{ request()->input('search') }}" ничего не найдено</div>
                @endif
            @endif
            <div class="table-container overflow-x-auto">
                <table class="table w-full border-collapse">
                    <thead class="bg-gray-200">
                    <tr class="text-center">
                        <th class="px-4 py-2 text-center">ID</th>
                        <th class="px-4 py-2 text-center">Изображение</th>
                        <th class="px-4 py-2 text-center">Название</th>
                        <th class="px-4 py-2 text-center">Цена</th>
                        <th class="px-4 py-2 text-center">Категория</th>
                        <th class="px-4 py-2 text-center">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2 text-center">{{ $product->id }}</td>
                            <td class="px-4 py-2 text-center flex justify-center"><img class="h-12"
                                                                                       src="{{asset('storage/imgss/'.$product->image_path)}}" alt=""></td>
                            <td class="px-4 py-2 text-center">{{ $product->title }}</td>
                            <td class="px-4 py-2 text-center">{{ $product->price }}</td>
                            <td class="px-4 py-2 text-center">{{ $product->category->title }}</td>
                            <td class="px-4 py-2 text-center text-nowrap">
                                <a href="{{ route('admin.product.edit', $product->id) }}"
                                   class="text-blue-500 hover:underline">Редактировать</a>
                                <a href="{{ route('admin.product.show', $product->id) }}"
                                   class="text-red-500 hover:underline ml-2">Удалить</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 flex justify-center gap-4">
                {{$products->links()}}
            </div>
        </div>
    </div>
@endsection
