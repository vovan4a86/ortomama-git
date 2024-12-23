@extends('template')
@section('content')
    @include('blocks.bread')
    <div class="container container--inner">
{{--        @include('catalog.blocks.product_aside')--}}
        <div class="container__main">
            <main>
                <section class="catalog">
                    <div class="catalog__title">{{ $h1 }}</div>
                    @include('catalog.blocks.catalog_per_page')
                    @if(count($products))
                        <div class="catalog__list">
                            @foreach($products as $product)
                                @include('catalog.product_item', compact('product'))
                            @endforeach
                        </div>
                        @include('paginations.catalog_pages', ['paginator' => $products])
                    @endif
                </section>
            </main>
        </div>
    </div>
@endsection
