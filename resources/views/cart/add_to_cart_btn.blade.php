<button class="btn btn--small btn--cart" type="button"
        @if(\Fanky\Admin\Cart::ifInCart($product_id))
            style="background-color: grey" disabled
        @endif
        data-product="{{ $product_id }}"
        data-create-order data-src="#create-order"
        onclick="addItemToCart(this, event)">
    <svg class="svg-sprite-icon icon-basket">
        <use xlink:href="/static/images/sprite/symbol/sprite.svg#basket"></use>
    </svg>
    @if(\Fanky\Admin\Cart::ifInCart($product_id))
        <span>В корзине</span>
    @else
        <span>В корзину</span>
    @endif
</button>