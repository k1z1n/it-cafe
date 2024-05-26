@extends('includes.template')
@section('head')
    <script src="{{ asset('js/code.js') }}" defer></script>
    <script src="{{ asset('js/register.js') }}" defer></script>
    <script src="{{ asset('js/ajax.js') }}" defer></script>
@endsection
@section('content')
    @include('auth.verify')
    @include('auth.send')
    <div class="container">
        <div class="flex overflow-x-auto max-h-[450px] mt-4">
            <img src="{{ asset('img/Монтажная область 1.png') }}" alt="" class="object-cover rounded-3xl">
            <img src="{{ asset('img/меню.png') }}" alt="" class="object-cover rounded-3xl">
        </div>
    </div>
    <section class="catalog z-20" id="catalog">
        <div class="container">
            <div class="text-2xl my-6">Акции</div>
            <div class="flex overflow-x-auto gap-x-3.5 pb-4">
                @foreach($popularProductsCurrentMonth as $pop)
                    <a href="{{ route('products.show', $pop->product->id) }}" class="">
                        <div class="flex gap-x-2 items-center shadow-md bg-white rounded-2xl w-64 h-full">
                            <div class="rounded-2xl p-3">
                                <img src="{{ asset('storage/imgss/'.$pop->product->image_path) }}" alt=""
                                     class="max-w-20 rounded-2xl">
                            </div>
                            <div class="flex flex-col">
                                <div class="text-sm">{{ $pop->product->title }}</div>
                                <div class="text-base font-medium">{{ $pop->product->price }} ₽</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="categories sticky-top">
            <div class="flex container items-center justify-between">
                <div class="flex">
                    <div id="logoM" class="hidden"><a href="{{ route('index') }}"><img src="{{ asset('img/loog.svg') }}" alt="Логотип"
                                                                        class="w-14"></a></div>
                    <div class="flex gap-3 ml-4 overflow-x-auto">
                        @foreach ($categories as $cat)
                            <div class="category">
                                <a href="#{{ $cat->title }}"
                                   class="line-height-0 category-link text-lg hover:text-[#3a86ff] transition-all duration-200">{{ $cat->title }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex items-center gap-5 hidden" id="right-category">
                    <div class="">89534815004</div>
                    <div>
                        @guest
                            <button id="openModalButton" class="text-white bg-[#3a86ff] outline-none px-5 py-1.5 rounded-3xl">
                                Войти
                            </button>
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
                </div>
            </div>
        </div>
        <script>
            window.addEventListener('scroll', function () {
                let categories = document.querySelector('.categories');
                let categoriesTop = categories.offsetTop;
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                let logo = document.getElementById('logoM')
                let rightC = document.getElementById('right-category')

                if (scrollTop >= categoriesTop) {
                    logo.classList.remove('hidden')
                    rightC.classList.remove('hidden')
                    categories.classList.add('bg-white');

                } else {
                    logo.classList.add('hidden')
                    rightC.classList.add('hidden')
                    categories.classList.remove('bg-white');
                }
            });
        </script>
        <div class="container">
            @foreach ($categories as $cat)
                <h2 class="mt-7 mb-4 text-4xl" id="{{ $cat->title }}">{{ $cat->title }}</h2>
                <div class="grid grid-cols-4 gap-y-6 gap-x-8 mb-14">
                    @foreach ($cat->products as $product)
                        <div
                            class="flex flex-col h-full justify-between p-4 shadow-custom bg-white rounded-3xl btn-show-product hover:scale-[1.05] duration-200"
                            data-product-id="{{ $product->id }}">
                            <div class="w-full">
                                <img class="mb-4 h-auto w-full object-cover rounded-xl"
                                     src="{{ asset('storage/imgss/'.$product->image_path) }}"
                                     alt="">
                                <h3 class="text-xl text-[#333333] font-bold block">{{ $product->title }}</h3>
                                <p class="text-gray-600 block text-sm mt-2">{{ $product->description }}</p>
                            </div>
                            <div class="w-full flex justify-between items-center mt-4">
                                <p class="text-black font-bold text-base">{{ $product->price }} ₽</p>
                                <form action="{{ route('cart.add') }}" method="post" class="flex items-center">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="submit" class="w-full py-2 px-5 bg-[#3a86ff] rounded-3xl text-white"
                                           value="в корзину">
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

        </div>
        <div id="productModal" class="fixed inset-0 overflow-y-auto hidden z-50 bg-black bg-opacity-80 rounded-2xl">
            <div class="flex items-center justify-center min-h-screen rounded-2xl">
                <div class="flex w-full max-w-4xl modal-product relative">
                    <div class="absolute right-[-10px] top-[-10px] bg-red-600 rounded-full p-0.5 cursor-pointer"
                         id="closeModal">
                        <img src="{{ asset('img/delete.svg') }}" alt=""></div>
                    <div class="w-1/2 bg-[#FCFCFC] rounded-l-3xl">
                        <img src="" class="modal-product-img h-[26.5rem] w-[28rem] p-8 object-cover rounded-l-2xl"
                             alt="Product Image">
                    </div>
                    <div class="p-4 w-1/2 flex flex-col bg-[#FCFCFC] justify-between rounded-r-2xl">
                        <div class="flex flex-col">
                            <h5 class="modal-product-title text-2xl font-medium mb-3"></h5>
                            <div class="flex gap-x-4 mb-2">
                                <div class="modal-product-weight text-gray-500"></div>
                                <div class="modal-product-count text-gray-500"></div>
                            </div>
                            <div class="modal-product-description mb-3"></div>
                            <div class="text-sm mb-4 text-gray-500">Состав: <span
                                    class="modal-product-structure text-black"></span></div>
                            <p class="modal-product-price bg-[#F3F3F7] w-full py-3 text-center rounded-xl text-sm"></p>
                        </div>
                        <div class="">
                            <form action="{{ route('cart.add') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id">
                                <input type="submit" class="w-full py-3 mt-2 bg-[#3a86ff] rounded-xl text-white"
                                       value="в корзину">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // Получаем все элементы товаров
            let productCards = document.querySelectorAll('.btn-show-product');

            // Получаем ссылку на модальное окно
            let modal = document.getElementById('productModal');

            // Добавляем обработчик события клика на каждый товар
            productCards.forEach(function (productCard) {
                productCard.addEventListener('click', function () {
                    // Получаем уникальный идентификатор товара из data-атрибута
                    let productId = productCard.getAttribute('data-product-id');

                    // Отправляем AJAX-запрос на сервер, чтобы получить данные о товаре по его идентификатору
                    fetch(`/products/${productId}`)
                        .then(response => response.json())
                        .then(product => {
                            modal.querySelector('input[name="product_id"]').value = product.id;
                            modal.querySelector('.modal-product-img').src = 'storage/imgss/' + product.image_path;
                            if (product.weight != null) {
                                modal.querySelector('.modal-product-weight').innerHTML = product.weight + ' г.';
                            }
                            if (product.count != null) {
                                modal.querySelector('.modal-product-count').innerHTML = product.count + ' шт.';
                            }
                            modal.querySelector('.modal-product-title').innerText = product.title;
                            modal.querySelector('.modal-product-description').innerText = product.description;
                            modal.querySelector('.modal-product-price').innerText = product.price + " ₽";
                            modal.querySelector('.modal-product-structure').innerHTML = product.structure
                            // Open modal after data is loaded
                            modal.classList.remove('hidden');
                        })
                        .catch(error => {
                            console.error('Ошибка загрузки данных о товаре:', error);
                        });
                });
            });

            // Добавляем обработчик события клика для закрытия модального окна
            document.getElementById('closeModal').addEventListener('click', function () {
                modal.classList.add('hidden');
            });

            // Закрываем модальное окно, если пользователь нажимает вне его области
            modal.addEventListener('click', function (event) {
                if (event.target === this) {
                    this.classList.add('hidden');
                }
            });

            const productModal = document.getElementById('productModal');
            const productArea = document.querySelector('.modal-product');

            document.addEventListener('click', function (event) {
                if (!productArea.contains(event.target) && event.target !== productModal) {
                    productModal.classList.add('hidden');
                }
            })
        </script>
        <div id="mod"></div>
        <script src="{{ asset('js/scroll.js') }}" defer></script>
    </section>
    <script defer>
        document.querySelectorAll('.category-link').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);

                window.scrollTo({
                    top: targetElement.offsetTop - document.querySelector('.categories').offsetHeight,
                    behavior: 'smooth'
                });
            });
        });
        document.addEventListener('scroll', function () {
            const scrollPosition = window.scrollY;

            let maxVisibleArea = 0;
            let activeCategory = null;

            document.querySelectorAll('.category').forEach(category => {
                const targetId = category.querySelector('.category-link').getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);

                const headerHeight = document.querySelector('.categories').offsetHeight;

                const blockTop = targetElement.offsetTop - headerHeight;
                const blockBottom = blockTop + targetElement.offsetHeight;

                const visibleArea = Math.min(blockBottom, scrollPosition + window.innerHeight) - Math.max(blockTop, scrollPosition);

                if (visibleArea > maxVisibleArea) {
                    maxVisibleArea = visibleArea;
                    activeCategory = targetElement;
                }
            });

            document.querySelectorAll('.category').forEach(category => {
                category.classList.remove('active');
            });
            if (activeCategory) {
                activeCategory.closest('.category').classList.add('active');
            }
        });

    </script>

@endsection
