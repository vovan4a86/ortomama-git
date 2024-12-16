<footer class="footer">
    <div class="footer__container container">
        <div class="footer__grid">
            <div class="footer__column">
                @if(Route::is('main'))
                    <span class="logo logo--white"></span>
                @else
                    <a class="logo logo--white" href="{{ route('main') }}" title="В начало"></a>
                @endif
            </div>
            <div class="footer__column">
                @if ($footerCatalog)
                    <div class="footer__title">Каталог</div>
                    <nav class="footer__nav nav-footer"></nav>
                    <ul class="nav-footer__list">
                        @foreach ($footerCatalog as $catItem)
                            <li class="nav-footer__item">
                                <a class="nav-footer__link" href="{{ $catItem->url }}"
                                   title="{{ $catItem->name }}">{{ $catItem->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            @if (count($footerMenu))
                <div class="footer__column">
                    <div class="footer__title">О компании</div>
                    <nav class="footer__nav nav-footer"></nav>
                    <ul class="nav-footer__list">
                        @foreach($footerMenu as $menuItem)
                        <li class="nav-footer__item">
                            <a class="nav-footer__link" href="{{ $menuItem->url }}" title="{{ $menuItem->name }}">
                                {{ $menuItem->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="footer__column">
                @if($phone = S::get('footer_phone'))
                    <a class="footer__phone" href="tel:{{ SiteHelper::clearPhone($phone) }}">{{ $phone }}</a>
                @endif
                @if($address = S::get('footer_address'))
                    <div class="footer__address">{{ $address }}</div>
                @endif
                @if($email = S::get('footer_email'))
                    <a class="footer__email" href="mailto:{{ $email }}">{{ $email }}</a>
                @endif
                <button class="footer__action btn" type="button" data-fancybox data-src="#create-request"
                        aria-label="Оставить заявку">
                    <span>Оставить заявку</span>
                </button>
            </div>
        </div>
        <div class="footer__copyright">
            <span>© {{ date('Y') }} {{ S::get('footer_copy') }}</span>
            <span>
                @if($address = S::get('footer_address'))
                    {{ $address }} |
                @endif
                 @if($phone = S::get('footer_phone'))
                    <a href="tel:{{ SiteHelper::clearPhone($phone) }}">{{ $phone }}</a>&nbsp;|
                 @endif
                @if($email = S::get('footer_email'))
                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                @endif
            </span>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="footer__container container">
            <div class="footer__row">
                <div class="footer__label">Все права защищены © ОртоМама</div>
                <div class="footer__dev">Разработка и продвижение сайта
                    <a href="https://fanky.ru" target="_blank">Fanky.ru</a>
                </div>
                <a class="footer__policy" href="{{ route('policy') }}" target="_blank">Политика конфиденциальности</a>
            </div>
        </div>
    </div>
</footer>
