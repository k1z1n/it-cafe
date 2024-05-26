<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">{{ $product->title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <p>{{ $product->description }}</p>
        <p>Цена: {{ $product->price }} ₽</p>
        <p>Категория: {{ $product->category->title }}</p>
    </div>
    <!-- resources/views/products/show.blade.php -->

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
    </div>

</div>
