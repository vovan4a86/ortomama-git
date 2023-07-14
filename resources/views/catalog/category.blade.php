@extends('template')
@section('content')
    @include('blocks.bread')
    <!-- aside layout-->
    <div class="layout">
        <div class="layout__container container">
            <button class="request-btn request-btn--accent btn-reset" type="button" data-popup="data-popup" data-src="#request" aria-label="Запрос менеджеру" data-title="Запрос менеджеру">
                <span class="request-btn__icon lazy" data-bg="/static/images/common/ico_request--white.svg"></span>
                <span class="request-btn__label">Запрос менеджеру</span>
            </button>
            @include('catalog.blocks.layout_aside')
            <div class="layout__content">
                <main>
                    <section class="section">
                        <div class="section__lead">{{ $category->name }}</div>
                        @if(count($category->children))
                            <div class="b-links">
                                <ul class="b-links__list list-reset">
                                    @foreach($category->children as $children)
                                        <li class="b-links__item">
                                            <a class="b-links__link" href="{{ $children->url }}"
                                               data-block-link>{{ $children->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(count($items))
                            <div class="b-cards">
                                <div class="b-cards__grid">
                                    @foreach($items as $item)
                                        @include('catalog.product_item', compact($item))
                                    @endforeach
                                </div>
                            </div>
                            <div class="section__pagination">
                                @include('catalog.section_pagination', ['paginator' => $items])
                            </div>
                        @endif
                        @include('blocks.send_detail_count')
                        @if($category->text)
                            <div class="section__subtitle">{{ $category->name }}</div>
                            {!! $category->text !!}
                        @endif
                    </section>
                </main>
            </div>
        </div>
    </div>
@endsection
