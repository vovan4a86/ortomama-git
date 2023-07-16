@if (count($cats_list))
    <section class="section section--gradient products">
        <div class="container">
            <h2 class="section__title centered">Продукция</h2>
            <div class="products__tabs tabs">
                <div class="products__links">
                    <span>Категории:</span>
                    @foreach($cats_list as $item)
                        <a class="products__link tabs__link" href="#tab-{{ $loop->index }}">{{ $item->name }}</a>
                    @endforeach
                </div>
                <div class="products__content">
                    @foreach($cats_list as $cat)
                        <div class="products__item tabs__item animate" id="tab-{{ $loop->index }}">
                            @if($cat->products)
                                <div class="products__grid">
                                    @foreach($cat->products as $product)
                                        <a class="products__card card" href="{{ $product->url }}"
                                       title="{{ $product->name }}">
										<span class="card__preview">
											<img class="lazy" data-src="{{ $product->image()->first()->thumb(4) }}"
                                                 src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                 alt="{{ $product->name }}" title="{{ $product->name }}"/>
										</span>
                                        <span class="card__title">{{ $product->name }}</span>
                                    </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif