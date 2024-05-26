@extends('admin.template')
@section('content')
    <div class="container mt-3">
        <div id="users" class="page">
            <h1 class="text-3xl font-bold my-6">Пользователи</h1>
            @if(session('success'))
                <div class="text-green-600 my-4">
                    {{ session('success') }}
                </div>
            @endif
            <form id="search-form" class="mb-3 flex gap-1.5 w-full" action="{{ route('admin.user.search') }}" method="get">
                <input type="text" id="search-input" name="search" placeholder="Поиск пользователей..." required
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
                        <th class="px-4 py-2 text-center">Имя</th>
                        <th class="px-4 py-2 text-center">Номер</th>
                        <th class="px-4 py-2 text-center">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2 text-center">{{ $user->id }}</td>
                            <td class="px-4 py-2 text-center">{{ $user->username }}</td>
                            <td class="px-4 py-2 text-center">{{ $user->phone_number }}</td>
                            <td class="px-4 py-2 text-center text-nowrap">
                                <form action="{{ route('admin.user.update-role', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    <select name="role" class="border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:border-blue-500">
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Пользователь</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Администратор</option>
                                        <option value="cashier" {{ $user->role == 'cashier' ? 'selected' : '' }}>Кассир</option>
                                    </select>
                                    <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Изменить роль</button>
                                </form>
                                <form action="{{ route('admin.user.update-status', $user) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    <select name="status" class="border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:border-blue-500">
                                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Активный</option>
                                        <option value="blocked" {{ $user->status == 'blocked' ? 'selected' : '' }}>Заблокирован</option>
                                    </select>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Изменить статус</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
