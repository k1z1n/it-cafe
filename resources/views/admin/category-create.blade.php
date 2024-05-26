@extends('admin.template')

@section('content')
    <div class="container flex justify-center items-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                <h2 class="text-2xl font-bold mb-4">Добавить категорию</h2>
                <form action="{{ route('admin.category.store') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Название</label>
                        <input type="text" class="input-custom" id="title" name="title" placeholder="Введите название категории">
                        @error('title')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex items-center justify-center">
                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
