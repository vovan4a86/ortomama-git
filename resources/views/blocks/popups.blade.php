<div class="cookie">
    <div class="cookie__container container">
        <div class="cookie__icon lazy" data-bg="/static/images/common/alert.svg"></div>
        <div class="cookie__info">
            <div class="cookie__label">Для лучшей работы сайта мы используем файлы cookies. Продолжая использовать сайт, вы соглашаетесь на работу с этими файлами</div>
            <button class="cookie__action btn-reset" type="button">
                <span>Принять и закрыть</span>
            </button>
        </div>
    </div>
</div>
<div class="popup" id="create-request" style="display:none">
    <form class="form" id="form" action="#">
        <div class="popup__title">Заказать сейчас</div>
        <div class="popup__content">
            <label class="popup__label">
                <input class="form__input" id="name" type="text" name="name" placeholder="Имя *" required autocomplete="off" data-validate-field="name">
            </label>
            <label class="popup__label">
                <input class="form__input" id="email" type="text" name="email" placeholder="E-mail *" required autocomplete="off" data-validate-field="email">
            </label>
            <textarea class="form__textarea" name="text" placeholder="Текст сообщения"></textarea>
            <button class="btn">
                <span>Отправить</span>
            </button>
        </div>
    </form>
</div>
<div class="popup" id="thanks" style="display:none">
    <div class="popup__title">Заказать сейчас</div>
    <div class="popup__text">Ваше сообщение успешно отправлено!</div>
</div>
<div class="popup" id="create-order" style="display:none"></div>
<div class="scrolltop">
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
				<g>
                    <polyline fill="none" stroke="#000000" stroke-width="2" stroke-linejoin="bevel" stroke-miterlimit="10" points="15,40 32,23
		49,40"></polyline>
                </g>
			</svg>
</div>
