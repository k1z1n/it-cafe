<div class="card h-100 modal-card-modal main-card btn-show-product" data-toggle="modal"  data-target="#productModal" data-product-id="{{ $product->id }}">
    <div class="d-flex card-product align-items-center">
        <div class="img-product">
            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->title }}" class="card-img-top mb-3">
        </div>
        <div class="card-body justify-content-between w-100">
            <h5 class="card-title">{{ $product->title }}</h5>
            <p class="card-text">{{ $product->description }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <span class="font-weight-semibold">{{ $product->price }} ₽</span>
{{--                <form action="{{ route('cart.add') }}" method="post">--}}
{{--                    @csrf--}}
{{--                    <input type="hidden" name="product_id" value="{{ $product->id }}">--}}
{{--                    <input type="hidden" name="quantity" value="1" min="1">--}}
{{--                    <input type="submit" class="btn btn-primary btn-sm die" value="в корзину">--}}
{{--                </form>--}}
            </div>
        </div>
    </div>
</div>
