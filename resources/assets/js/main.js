'use strict';

const api = '/ajax/get-products';
const cartLink = '/cart';

document.addEventListener('DOMContentLoaded', () => {
  cookie();

  gsap.config({ nullTargetWarn: false });

  Fancybox.bind('[data-fancybox]', {
    hideClass: 'fancybox-zoomOut',
    infinite: false
  });

  Fancybox.bind('[data-create-order]', {
    hideClass: 'fancybox-zoomOut',
    mainClass: 'popup--request',
    on: {
      closing: (e, trigger) => {
        setTimeout(() => {
          document.querySelector('[data-temp-data]').remove();
        }, 350);
      },

      reveal: (e, trigger) => {
        async function getProduct() {
          const response = await fetch(api);
          return await response.json();
        }

        getProduct().then(
          data =>
            data.length &&
            filteredProduct(data, trigger.product).map(product => {
              trigger.$content.insertAdjacentHTML(
                'beforeend',
                createPopupTemplate(product)
              );
            })
        );

        const filteredProduct = (array, srcId) =>
          array.filter(item => item.id === srcId);

        function createPopupTemplate(array) {
          const { image, title, data } = array;

          return `
            <div class="popup__container" data-temp-data>
              <div class="popup__label">Товар добавлен</div>
              <div class="popup__row">
                <div class="popup__picture">
                  <img src=${image || ''} width="120" height="120" alt="">
                </div>
                <div class="popup__info">
                  <div class="popup__subtitle">${title || ''}</div>
                  ${
                    data &&
                    `
                      <div class="popup__data">
                        ${data
                          .map(
                            item => `
                            <dl class="param">
                              <dt class="param__key"><span>${item.key}</span></dt>
                              <dd class="param__value">${item.value}</dd>
                            </dl>
                          `
                          )
                          .join('')}
                      </div>
                    `
                  }
                  <div class="popup__footer">
                    <div class="popup__grid">
                      <a class="popup__button popup__button--accent" href=${cartLink}>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                          <path fill="currentColor" d="M16 3.094L7.094 12H2v6h1.25l2.781 9.281l.219.719h19.5l.219-.719L28.75 18H30v-6h-5.094zm0 2.844L22.063 12H9.938zM4 14h24v2h-.75l-.219.719L24.25 26H7.75l-2.781-9.281L4.75 16H4zm7 3v7h2v-7zm4 0v7h2v-7zm4 0v7h2v-7z" />
                        </svg>
                        <span>Перейти в корзину</span>
                      </a>
                      <button class="popup__button popup__button--outlined btn-reset" type="button" onclick="Fancybox.close()">
                        <span>Продолжить покупки</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          `;
        }
      }
    }
  });

  wrappTables();
  showThankDialog('[data-mailing]');

  ////
  animateTitles('.section__title');
  animateBenefits();

  ////
  $('.preloader').fadeOut();
  $('body').removeClass('no-scroll');

  ////
  new LazyLoad();

  ////
  $('input[type="tel"], input[name="tel"]').inputmask('+7 (999) 999-99-99', {
    showMaskOnHover: false
  });

  $('input[name="email"]').inputmask('email', { showMaskOnHover: false });

  ////
  $('img, a').on('dragstart', function (event) {
    event.preventDefault();
  });
  $('img, picture').on('contextmenu', function () {
    return false;
  });

  ////
  const asideNav = document.querySelector('.aside__nav');

  if (asideNav) {
    asideNav.addEventListener('click', function (e) {
      const target = e.target;

      if (target.classList.contains('aside__link')) {
        e.preventDefault();

        const subList = target.parentNode.querySelector('.aside__sublist');
        const link = target.parentNode.querySelector('.aside__link');

        link.classList.toggle('active');
        subList.classList.toggle('active');
      }
    });
  }

  ////
  $('.aside__sublink')
    .filter('[href="' + window.location + '"]')
    .addClass('active')
    .closest('.aside__sublist')
    .addClass('active')
    .siblings('.aside__link')
    .addClass('active');

  ////
  $(window).on('scroll', function () {
    if ($(window).scrollTop() > 300) {
      const scroller = $('.scrolltop');

      scroller.addClass('scrolltop--show');

      scroller.on('click', function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
      });
    } else {
      $('.scrolltop').removeClass('scrolltop--show');
    }
  });

  ////
  $('[data-burger]').on('click', function () {
    const header = $('[data-header]');

    $(this).toggleClass('is-active');
    header.toggleClass('active');
    $('body').toggleClass('no-scroll');
  });

  ////
  $('.nav__link')
    .filter('[href="' + window.location + '"]')
    .addClass('active');

  ////
  $('.tabs__link').on('click', function (e) {
    e.preventDefault();

    $('.tabs__link').removeClass('active');
    $('.tabs__item').removeClass('active');

    $(this).addClass('active');
    $($(this).attr('href')).addClass('active');
  });

  $('.tabs__link:first').trigger('click');

  ////
  const mainSlider = new Swiper('[data-main-slider]', {
    speed: 200,
    lazy: true,
    effect: 'fade',
    fadeEffect: {
      crossFade: true
    },
    pagination: {
      el: '.slider__pagination',
      clickable: true
    },
    navigation: {
      nextEl: '.slider__next',
      prevEl: '.slider__prev'
    },
    on: {
      runCallbacksOnInit: true,
      init: function () {
        animateSlide(this.$el);
        animateCatalogSlider();
      },
      slideNextTransitionStart: function () {
        animateSlide(this.$el);
      },
      slidePrevTransitionStart: function () {
        animateSlide(this.$el);
      }
    }
  });

  ////
  const reviewsSlider = new Swiper('[data-reviews-slider]', {
    speed: 800,
    autoHeight: true,
    pagination: {
      el: '.reviews__pagination',
      clickable: true
    },
    navigation: {
      nextEl: '.reviews__next',
      prevEl: '.reviews__prev'
    }
  });

  ////
  const viewedSlider = new Swiper('[data-viewed-slider]', {
    speed: 800,
    slidesPerView: 1.3,
    spaceBetween: 10,
    lazy: true,
    centeredSlides: true,
    navigation: {
      nextEl: '.nav-viewed__next',
      prevEl: '.nav-viewed__prev'
    },
    breakpoints: {
      768: {
        slidesPerView: 2.1
      },
      1024: {
        slidesPerView: 3.5
      },
      1440: {
        centeredSlides: true,
        slidesPerView: 3.8
      },
      1920: {
        centeredSlides: false,
        slidesPerView: 4,
        spaceBetween: 20
      }
    }
  });

  const $filterHead = $('[data-filter-head]');
  $filterHead && spoilerInit($filterHead, '[data-filter-content]');

  initAsideMenus($('[data-filter-open]'), '[data-filter-body]', 'фильтр');
  initAsideMenus($('[data-aside-open]'), '[data-aside-body]', 'меню');

  function initAsideMenus(trigger, content, point) {
    if (trigger) {
      trigger.on('click', function () {
        const $content = $(this).siblings(content);

        $(this).toggleClass('is-active');

        $(this).hasClass('is-active')
          ? openFilter($(this), $content)
          : closeFilter($(this), $content);

        function openFilter(trigger, body) {
          trigger.find('span').text(`Скрыть ${point}`);
          body.fadeIn('fast');
        }

        function closeFilter(trigger, body) {
          trigger.find('span').text(`Показать ${point}`);
          body.fadeOut('fast');
        }
      });
    }
  }

  initCounter();

  const mapSelect = document.querySelector('[data-map-select]');
  mapSelect && initMapSelect(mapSelect);

  const selects = document.querySelectorAll('[data-select]');
  selects && selects.forEach(select => initSelects(select));
});

function initSelects(select) {
  new SlimSelect({
    select: select,
    searchPlaceholder: 'Найти:',
    searchText: 'Не найдено'
  });
}

function initMapSelect(select) {
  new SlimSelect({
    select: select,
    showSearch: false,
    onChange: info => {
      if (info.data) {
        const { longitude, latitude, label } = info.data;
        const id = map.id;

        map.innerHTML = '';
        initMap(id, latitude, longitude, 15, label);
      }
    }
  });
}

const map = document.querySelector('[data-map]');

if (map) {
  const latitude = map.dataset.latitude;
  const longitude = map.dataset.longitude;
  const label = map.dataset.label;
  const id = map.id;

  initMap(id, latitude, longitude, 18, label);
}

function initCounter() {
  const counters = document.querySelectorAll('[data-counter]');

  counters &&
    counters.forEach(counter => {
      counter.addEventListener('click', function (e) {
        const input = this.querySelector('[data-count]');
        const target = e.target;

        if (target.closest('.counter__btn--prev') && input.value > 1) {
          input.value--;
        } else if (target.closest('.counter__btn--next')) {
          input.value++;
        }

        input.addEventListener('change', function () {
          if (this.value < 0 || this.value === '0' || this.value === '') {
            this.value = 1;
          }
        });
      });
    });
}

function spoilerInit(head, content) {
  head.each(function () {
    $(this).on('click', function () {
      $(this).toggleClass('is-active');
      $(this).siblings(content).slideToggle(250);
    });
  });
}

function animateSlide(sliderDOM) {
  const slideActive = sliderDOM.find(
    '.swiper-slide-active, .swiper-slide-duplicate-active'
  );
  const title = slideActive.find('.slider__title');
  const content = slideActive.find('.slider__list');
  const image = slideActive.find('.slider__preview img');

  gsap.from(title, { x: -30, opacity: 0 });
  gsap.from(content, { x: 15, opacity: 0 });
  gsap.from(image, { y: -20, opacity: 0 });

  gsap.to(title, { duration: 1, x: 0, opacity: 1 });
  gsap.to(content, { duration: 1, x: 0, opacity: 1 });
  gsap.to(image, { duration: 1, y: 0, opacity: 1 });
}

function animateCatalogSlider() {
  const catalogSlider = $('.catalog-slider');

  const animate = gsap.timeline({
    scrollTrigger: {
      trigger: catalogSlider
    }
  });

  animate.fromTo(
    catalogSlider,
    { y: 10, opacity: 0 },
    { y: 0, opacity: 1, duration: 0.5, delay: 0.02 },
    1
  );
}

function animateTitles(titles) {
  $(titles).each(function () {
    const animate = gsap.timeline({
      scrollTrigger: {
        trigger: $(this)
      }
    });

    animate.fromTo(
      $(this),
      { y: -10, opacity: 0 },
      { y: 0, opacity: 1, duration: 0.5, delay: 1 },
      0.5
    );
  });
}

function animateBenefits() {
  const benefitsGrid = $('.benefits__grid > div');

  const animate = gsap.timeline({
    scrollTrigger: {
      trigger: benefitsGrid
    }
  });

  animate.fromTo(
    benefitsGrid,
    { y: 20, opacity: 0 },
    { y: 0, opacity: 1, duration: 0.75, stagger: 0.2 },
    0
  );
}

function showThankDialog(formAttribute) {
  const form = document.querySelector(formAttribute);

  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      Fancybox.show([
        {
          src: '#thanks',
          type: 'inline'
        }
      ]);

      form.reset();
    });
  }
}

/// validate request form
function validateForms(selector, rules) {
  new window.JustValidate(selector, {
    rules: rules,
    colorWrong: '#FF8F81',
    messages: {
      name: {
        required: 'Пожалуйста, введите ваше имя',
        minLength: 'Введите 3 и более символов',
        maxLength: 'Запрещено вводить более 15 символов'
      },
      email: {
        email: 'Введите корректный email',
        required: 'Пожалуйста, введите email'
      }
      // tel: {
      //   required: 'Введите телефон',
      //   function: 'Здесь должно быть 10 символов без +7'
      // }
    }
  });
}

validateForms('#form', {
  email: { required: true, email: true },
  name: { required: true },
  tel: { required: true }
});

////
function wrappTables() {
  let tables = document.getElementsByTagName('table'),
    length = tables.length,
    i,
    wrapper;

  for (i = 0; i < length; i++) {
    wrapper = document.createElement('div');
    wrapper.setAttribute('class', 'hscroll');
    tables[i].parentNode.insertBefore(wrapper, tables[i]);
    wrapper.appendChild(tables[i]);
  }
}

function initMap(idmap, lat, lon, zoom, text) {
  ymaps.ready(function () {
    var myMap = new ymaps.Map(
        idmap,
        {
          center: [lat, lon],
          zoom: zoom,
          controls: ['zoomControl']
        },
        {
          searchControlProvider: 'yandex#search'
        }
      ),
      myPlacemark = new ymaps.Placemark(
        myMap.getCenter(),
        {
          hintContent: text,
          balloonContent: text
        },
        {
          iconLayout: 'default#image',
          iconImageHref: 'static/images/common/ico_pin.svg',
          iconImageSize: [30, 40],
          iconImageOffset: [-15, -20]
        }
      );
    myMap.geoObjects.add(myPlacemark);
    myMap.behaviors.disable('scrollZoom');
    if (window.innerWidth < 600) {
      myMap.behaviors.disable('drag');
    }
  });
}

const isLocalStorageEnabled = () => {
  try {
    const key = `__storage__test`;
    window.localStorage.setItem(key, null);
    window.localStorage.removeItem(key);
    return true;
  } catch (e) {
    return false;
  }
};

function cookie() {
  const cookieBlock = $('.cookie');

  localStorage.getItem('orto-cookie')
    ? cookieBlock.remove()
    : showCookieDialog();

  function showCookieDialog() {
    setTimeout(() => {
      cookieBlock.addClass('is-active');
    }, 3000);
  }

  cookieBlock.on('click', function (event) {
    const target = event.target;

    target.closest('.cookie__action') && cookieBlock.fadeOut(250);

    isLocalStorageEnabled() && localStorage.setItem('orto-cookie', 'confirmed');
  });
}
