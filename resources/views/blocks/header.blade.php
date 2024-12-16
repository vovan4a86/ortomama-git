<header class="header header--homepage">
    <div class="header__container container" data-header>
        <div class="header__logo">
            @if(Route::is('main'))
                <span class="logo logo--black"></span>
            @else
                <a class="logo logo--black" href="{{ route('main') }}" title="В начало"></a>
            @endif
        </div>
        <div class="header__nav">
            @if (count($topMenu))
            <nav class="nav" itemscope itemtype="https://schema.org/SiteNavigationElement" aria-label="Меню">
                <ul class="nav__list" itemprop="about" itemscope itemtype="https://schema.org/ItemList">
                    @foreach($topMenu as $menuItem)
                        <li class="nav__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList">
                            <a class="nav__link" href="{{ $menuItem->url }}" title="{{ $menuItem->name }}" itemprop="url">{{ $menuItem->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
            @endif
            <form class="search" action="{{ route('search') }}">
                <input class="search__input" type="search" name="search" placeholder="Поиск по сайту" value="{{ Request::get('search') }}">
                <button class="search__button" type="submit">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 15L12.2186 12.0575C13.3249 10.9116 13.9738 9.40054 14.0432 7.80917C14.1125 6.2178 13.5973 4.65604 12.5949 3.41825C11.5924 2.18045 10.1718 1.35213 8.60087 1.08939C7.02994 0.826658 5.41717 1.14766 4.06653 1.9919C2.7159 2.83614 1.72069 4.14531 1.26849 5.67264C0.816292 7.19997 0.938335 8.83997 1.61162 10.2835C2.2849 11.7271 3.46291 12.8745 4.92362 13.5095C6.38434 14.1445 8.02686 14.2232 9.54159 13.7308"
                              stroke="black" stroke-opacity="0.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                </button>
            </form>
        </div>
        <div class="header__contacts contacts-header">
            @include('blocks.header_cart')
            @if($phone = S::get('header_phone'))
                <div class="header__column">
                    <a class="contacts-header__phone" href="tel:{{ SiteHelper::clearPhone($phone) }}">{{ $phone }}</a>
                    <div class="contacts-header__label">Звонок по России бесплатный</div>
                </div>
            @endif
            <div class="header__column">
                <button class="contacts-header__action btn" type="button" data-fancybox data-src="#create-request" aria-label="Заказать сейчас">
                    <span>Заказать сейчас</span>
                </button>
            </div>
        </div>
    </div>
    <div class="container header__mobile">
        <div class="header__logo">
            <a class="logo logo--black" href="{{ route('main') }}" title="В начало"></a>
        </div>
        <div class="header__burger">
            <button class="hamburger hamburger--collapse" type="button" data-burger>
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
</header>
