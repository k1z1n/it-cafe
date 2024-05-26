@extends('admin.template')
@section('content')
    <div class="container flex justify-center items-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h2 class="text-2xl font-bold mb-4">Удалить продукт "{{ $product->title }}"?</h2>
                <form action="{{ route('admin.product.destroy', $product->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="flex flex-col items-center gap-y-3">
                        <button type="button" onclick="window.history.back()"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 w-full rounded focus:outline-none focus:shadow-outline">
                            Назад
                        </button>
                        <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 w-full rounded focus:outline-none focus:shadow-outline">
                            Удалить
                        </button>
                    </div>
                </form>
            </div>
        </div>
@endsection
