<div class="tbl-order__row tbl-order__row--footer">
    <div class="tbl-order__col tbl-order__col--pic"></div>
    <div class="tbl-order__col tbl-order__col--name">Итого:</div>
    <div class="tbl-order__col tbl-order__col--count">{{ \Fanky\Admin\Cart::total_items() }}</div>
    <div class="tbl-order__col tbl-order__col--price">{{ \Fanky\Admin\Cart::sum() }}</div>
    <div class="tbl-order__col tbl-order__col--discount">{{ \Fanky\Admin\Cart::total_discount() }}</div>
    <div class="tbl-order__col tbl-order__col--total">{{ \Fanky\Admin\Cart::sum_with_discount() }}</div>
</div>
