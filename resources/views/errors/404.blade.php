@extends('template')
@section('content')
    <nav class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li class="breadcrumbs__item" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <a class="breadcrumbs__link" href="{{ route('main') }}" itemprop="item">
                        <span itemprop="name">Главная</span>
                        <meta itemprop="position" content="1">
                    </a>
                </li>
                <li class="breadcrumbs__item" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <a class="breadcrumbs__link" href="javascript:void(0)"
                       itemprop="item">
                        <span itemprop="name">Страница не найдена</span>
                        <meta itemprop="position" content="2">
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <main>
        <section class="error">
            <div class="error__container container">
                <div class="error__title centered">Эта страница не найдена</div>
                <div class="error__decor lazy" data-bg="/static/images/common/404.png"></div>
                <div class="error__text centered">Данной страницы не существует, приносим свои извинения! Пожалуйста, вернитесь на главную или продолжайте выбирать обувь.</div>
                <div class="actions-block">
                    <a class="actions-block__btn actions-block__btn--accent" href="{{ route('main') }}" title="Вернуться на главную">
                        <span>Вернуться на главную</span>
                    </a>
                    <a class="actions-block__btn actions-block__btn--outlined" href="{{ route('catalog.index') }}" title="Перейти в каталог">
                        <span>Перейти в каталог</span>
                    </a>
                </div>
            </div>
        </section>
    </main>
@stop
