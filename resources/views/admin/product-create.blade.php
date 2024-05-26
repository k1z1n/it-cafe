@extends('admin.template')
@section('content')
    <div class="container flex justify-center items-center my-4">
        <div class="w-full max-w-md shadow-custom my-4">
            <div class="bg-white rounded px-8 pt-6 pb-8">
                <h2 class="text-2xl font-bold mb-4">Добавить продукт</h2>
                <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Название</label>
                        <input type="text" class="input-custom" id="title" name="title"
                               placeholder="Введите название продукта">
                        @error('title')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Описание</label>
                        <textarea type="text" class="input-custom" id="description" name="description"
                                  placeholder="Введите описание продукта"></textarea>
                        @error('description')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="structure" class="block text-gray-700 text-sm font-bold mb-2">Состав</label>
                        <textarea type="text" class="input-custom" id="structure" name="structure"
                                  placeholder="Введите состав продукта"></textarea>
                        @error('structure')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Цена</label>
                        <input type="number" class="input-custom" id="price" name="price"
                               placeholder="Введите цену продукта">
                        @error('price')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="weight" class="block text-gray-700 text-sm font-bold mb-2">Вес</label>
                        <input type="number" class="input-custom" id="weight" name="weight"
                               placeholder="Введите вес продукта">
                        @error('weight')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="count" class="block text-gray-700 text-sm font-bold mb-2">Количество</label>
                        <input type="number" class="input-custom" id="count" name="count"
                               placeholder="Введите количество продукта">
                        @error('count')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Категория</label>
                        <select class="input-custom" id="category_id" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="photo" class="block text-gray-700 text-sm font-bold mb-2">Изображение</label>
                        <input type="file" class="input-custom" id="image" name="image_path">
                        @error('photo')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex items-center justify-center">
                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl focus:outline-none focus:shadow-outline">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
