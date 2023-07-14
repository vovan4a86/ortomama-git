<footer class="footer">
    <div class="footer__container container">
        <div class="footer__grid">
            <div class="footer__column">
                <a class="logo logo--white" href="{{ route('main') }}" title="В начало"></a>
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
                <a class="footer__phone" href="tel:+79122711515">+7 (912) 271-15-15</a>
                <div class="footer__address">г. Полевской, микр. Зеленый Бор, 19</div>
                <a class="footer__email" href="mailto:info@ortoposhiv.ru">info@ortoposhiv.ru</a>
                <button class="footer__action btn" type="button" data-fancybox data-src="#create-request"
                        aria-label="Оставить заявку">
                    <span>Оставить заявку</span>
                </button>
            </div>
        </div>
        <div class="footer__copyright">
            <span>© 2022 Пошив ортопедической обуви</span>
            <span>Екатеринбург, Ленина, 1 |
						<a href="tel:+73434589755">+7 (343) 458-97-55</a>&nbsp;|
						<a href="mailto:info@ortoposhiv.ru">info@ortoposhiv.ru</a>
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
