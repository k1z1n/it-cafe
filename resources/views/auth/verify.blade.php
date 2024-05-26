<div id="createSms" class="hidden fixed inset-0 bg-black bg-opacity-80 justify-center items-center z-50">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md transform translate-x-[-50%] translate-y-[-50%] relative left-1/2 top-1/2">
        <button onclick="closeCreate()"><img src="{{ asset('img/krest.svg') }}"
                                                class="absolute top-0 right-[-60px] z-[60] hover:scale-110 transition-all duration-150"
                                                alt=""></button>
        <h1 class="text-3xl">Вход на сайт</h1>
        <p>Код отправлен на номер</p>
        <p>{{$phone = Cookie::get('phone_number') }}</p>
        <form id="verifyCodeForm" method="POST" action="{{ route('auth.verify-code') }}">
            @csrf
            <label for="verificationCode" class="block text-sm font-medium text-gray-700">Код авторизации:</label>
            <input type="text" id="verificationCode"
                   class="mt-1 block w-full px-3 py-2 border border-black rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                   name="verificationCode" required>
            @if(session('error'))
                {{ session('error') }}
            @endif
            <div id="errorMessage" style="color: red;"></div>
            <button id="smsTake" type="submit" class="mt-4 w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Подтвердить</button>
            <div>
                <div class="text-[10px] pt-2 text-center">Продолжая, вы соглашаетесь<a href="" class="ml-1 text-blue-600">со
                        сбором и обработкой персональных данных и пользовательским соглашением</a></div>
            </div>
        </form>
    </div>
</div>
