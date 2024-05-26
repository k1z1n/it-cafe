<div id="updateProfile" class="hidden fixed inset-0 bg-black bg-opacity-80 justify-center items-center z-50">
    <div
        class="bg-white rounded-lg shadow-lg max-w-[300px] transform translate-x-[-50%] translate-y-[-50%] relative left-1/2 top-1/2">
        <div class=" p-4 flex flex-col">
            <h2 class="text-2xl font-bold mb-4">Обновить профиль</h2>
            <form method="post" action="{{ route('user.update') }}" class="">
                @csrf
                @method('put')
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Имя</label>
                    <input type="text" class="input-custom" id="username" name="username"
                           placeholder="Введите имя" value="{{ auth()->user()->username }}">
                    @error('username')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" class="input-custom" id="email" name="email"
                           placeholder="Введите email" value="{{ auth()->user()->email }}">
                    @error('email')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Дата рождения</label>
                    <input type="date" class="input-custom" id="date" name="date" value="{{ auth()->user()->date }}">
                    @error('date')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-full">
                    <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl focus:outline-none focus:shadow-outline">
                        Добавить
                    </button>
                </div>
            </form>
        </div>
        <div class="absolute right-[-10px] top-[-10px]">
            <button type="submit" class="bg-red-600 rounded-full p-0.5 hover:transform scale-100">
                <img src="{{ asset('img/delete.svg') }}" id="close" alt=""></button>
        </div>
    </div>
</div>
