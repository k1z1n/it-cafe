@extends('admin.template')
@section('content')
    <div class="container mt-3">
        <div id="categories" class="page">
            <h1 class="text-3xl font-bold my-6">Категории</h1>
            @if(session('success'))
                <div class="text-green-600 my-4">
                    {{ session('success') }}
                </div>
            @endif
            <form id="search-form" class="mb-3 flex gap-1.5 w-full" action="{{ route('admin.category.search') }}" method="get">
                <input type="text" id="search-input" name="search" placeholder="Поиск категории..." required
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
                        <th class="px-4 py-2 text-center">Название</th>
                        <th class="px-4 py-2 text-center">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2 text-center">{{ $category->id }}</td>
                            <td class="px-4 py-2 text-center">{{ $category->title }}</td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('admin.category.edit', $category->id) }}"
                                    class="text-blue-500 hover:underline">Редактировать</a>
                                <a href="{{ route('admin.category.show', $category->id) }}"
                                   class="text-red-500 hover:underline ml-2">Удалить</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 flex justify-center gap-4">
                {{$categories->links()}}
            </div>
        </div>
    </div>
@endsection
