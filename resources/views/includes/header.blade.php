<header class="bg-[#FFF] text-white border-[#f1f1f1] border-b ">
    <div class="container mx-auto px-4">
        <nav class="grid grid-cols-3 py-6">
            <div class="flex items-center justify-start">
                <a href="/" class="flex items-center gap-2">
                    <img src="{{ asset('img/loog.svg') }}" alt="Логотип" height="40" class="w-20">
                    <p class="text-black text-xl">IT-CAFE</p>
                </a>
{{--                <div class="text-sm">Доступна доставка<br>по Казани</div>--}}
            </div>
            <div class="flex gap-4 justify-center items-center text-black">
                <div class="w-full m-auto lg:max-w-[25rem] sm:max-w-[15rem] sx:max-w-[10rem]">
                    <form action="" method="get"
                          class="relative bg-f9f9f9 border-black border-opacity-5 border-solid border-0.5 w-full">
                        <!-- Здесь может быть форма поиска -->
                        <input type="text" placeholder="Поиск" name="query"
                               class="shadow-custom pl-5 text-black lg:py-2 sx:py-1 rounded-2xl outline-none lg:max-w-[25rem] sm:max-w-[15rem] sx:max-w-[10rem] w-full header-input-background">
                        <button type="submit" class="absolute inset-y-0 right-0 pr-2 flex items-center justify-center z-20">
                            <img src="{{ asset('img/search.svg') }}" alt="Поиск" class="h-[20px]">
                        </button>
                    </form>
                    <div id="search-history" class="mt-4 hidden">
                        <h3 class="text-lg font-medium mb-2">История поиска</h3>
                        <ul id="search-history-list"></ul>
                    </div>
                </div>
            </div>
            <div class="flex gap-4 justify-end items-center">
                @guest
                    <button id="openModalButton" class=" bg-[#3a86ff] outline-none px-5 py-1.5 rounded-3xl">Войти</button>
{{--                    <div class="flex items-center gap-2">--}}
{{--                        <a href="">--}}

{{--                        </a>--}}
{{--                        <img src="{{ asset('img/user.svg') }}" alt="profile" class="w-8 h-8 cursor-pointer" id="openModalButton">--}}
{{--                    </div>--}}
{{--                    <div class="flex items-center gap-2">--}}
{{--                        <img src="{{ asset('img/cart.svg') }}" alt="cart" class="h-6 cursor-pointer" id="openModalButton">--}}
{{--                    </div>--}}
                @endguest
                @auth
                    <div class="flex items-center gap-2">
                        <a href="{{ route('profile') }}">
                            <img src="{{ asset('img/user.svg') }}" alt="profile" class="w-8 h-8">
                        </a>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('cart') }}">
                            <img src="{{ asset('img/cart.svg') }}" alt="cart" class="h-6">
                        </a>
                    </div>
                @endauth
            </div>
        </nav>
    </div>
</header>
