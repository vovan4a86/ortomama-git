<div class="container__aside">
    <aside class="aside">
        <div class="aside__head" data-aside-open>
            <span>Показать меню</span>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1em" height="1em"
                 preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"
                 style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);">
                <path fill="currentColor"
                      d="M160 448a32 32 0 0 1-32-32V160.064a32 32 0 0 1 32-32h256a32 32 0 0 1 32 32V416a32 32 0 0 1-32 32H160zm448 0a32 32 0 0 1-32-32V160.064a32 32 0 0 1 32-32h255.936a32 32 0 0 1 32 32V416a32 32 0 0 1-32 32H608zM160 896a32 32 0 0 1-32-32V608a32 32 0 0 1 32-32h256a32 32 0 0 1 32 32v256a32 32 0 0 1-32 32H160zm448 0a32 32 0 0 1-32-32V608a32 32 0 0 1 32-32h255.936a32 32 0 0 1 32 32v256a32 32 0 0 1-32 32H608z"
                />
            </svg>
        </div>
        @if (count($categories))
            <nav class="aside__nav" data-aside-body>
                <ul class="aside__list">
                    @foreach($categories as $cat)
                        <li class="aside__item">
                            <a class="aside__link {{ $cat->isActive ? 'active' : '' }}" href="{{ $cat->url }}"
                               title="{{ $cat->name }}">{{ $cat->name }}</a>
                            @if($cat->public_children)
                                <ul class="aside__sublist {{ $cat->isActive ? 'active' : '' }}">
                                    @foreach($cat->public_children as $children)
                                        <li class="aside__subitem">
                                            <a class="aside__sublink {{ $children->isActive ? 'active' : '' }}"
                                               href="{{ $children->url }}"
                                               title="{{ $children->name }}">{{ $children->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif
    </aside>
    <div class="container__divider"></div>
    <form class="filter" action="{{ $category->url }}">
        <div class="filter__show" data-filter-open>
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet"
                 viewBox="0 0 16 16">
                <path fill="currentColor"
                      d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
            </svg>
            <span>Показать фильтр</span>
        </div>
        <div class="filter__body" data-filter-body>
            <div class="filter__grid">
                @if (count($filter_sizes))
                    <div class="filter__item">
                        <div class="filter__head" data-filter-head>
                            <div class="filter__title">Размер</div>
                            <div class="filter__icon">
                                <svg class="svg-sprite-icon icon-dropdown">
                                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#dropdown"></use>
                                </svg>
                            </div>
                        </div>
                        <div class="filter__content" data-filter-content>
                            <div class="filter__sizes">
                                @foreach($filter_sizes as $size)
                                    <div class="radios">
                                        <label class="radios__label">
                                            <input class="radios__input" type="checkbox" name="sizes[]"
                                                   value="{{ $size->value }}"
                                                    {{ in_array($size->id, $filter_data['sizes']) ? 'checked' : null }}
                                            />
                                            <span class="radios__box">{{ $size->value }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="filter__action">
                                <button class="filter__submit btn-reset">
                                    <span>Показать</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                @if (count($filter_seasons))
                    <div class="filter__item">
                    <div class="filter__head" data-filter-head>
                        <div class="filter__title">Сезон</div>
                        <div class="filter__icon">
                            <svg class="svg-sprite-icon icon-dropdown">
                                <use xlink:href="/static/images/sprite/symbol/sprite.svg#dropdown"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="filter__content" data-filter-content>
                        <div class="filter__list">
                            @foreach($filter_seasons as $season)
                                <label class="checkbox">
                                    <input class="checkbox__input" type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                            {{ isset($filter_data['seasons']) && in_array($season->id, $filter_data['seasons']) ? 'checked' : null }}
                                    />
                                    <span class="checkbox__box"></span>{{ $season->value }}
                                </label>
                            @endforeach
                        </div>
                        <div class="filter__action">
                            <button class="filter__submit btn-reset">
                                <span>Показать</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                @if (count($filter_brands))
                    <div class="filter__item">
                        <div class="filter__head" data-filter-head>
                            <div class="filter__title">Бренд</div>
                            <div class="filter__icon">
                                <svg class="svg-sprite-icon icon-dropdown">
                                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#dropdown"></use>
                                </svg>
                            </div>
                        </div>
                        <div class="filter__content" data-filter-content>
                            <div class="filter__list">
                                @foreach($filter_brands as $brand)
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox" name="brand[]"
                                               value="{{ $brand->id }}"
                                                {{ in_array($brand->id, $filter_brand) ? 'checked' : null }}
                                        />
                                        <span class="checkbox__box"></span>{{ $brand->name }}
                                    </label>
                                @endforeach
                            </div>
                            <div class="filter__action">
                                <button class="filter__submit btn-reset">
                                    <span>Показать</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                @if (count($filter_genders))
                    <div class="filter__item">
                    <div class="filter__head" data-filter-head>
                        <div class="filter__title">Пол</div>
                        <div class="filter__icon">
                            <svg class="svg-sprite-icon icon-dropdown">
                                <use xlink:href="/static/images/sprite/symbol/sprite.svg#dropdown"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="filter__content" data-filter-content>
                        <div class="filter__list">
                            @foreach($filter_genders as $gender)
                                <label class="checkbox">
                                    <input class="checkbox__input" type="checkbox" name="genders[]" value="{{ $gender->id }}"
                                    {{ isset($filter_data['genders']) && in_array($gender->id, $filter_data['genders']) ? 'checked' : null }}
                                    />
                                    <span class="checkbox__box"></span>{{ $gender->value }}
                                </label>
                            @endforeach
                        </div>
                        <div class="filter__action">
                            <button class="filter__submit btn-reset">
                                <span>Показать</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                @if (count($filter_types))
                    <div class="filter__item">
                        <div class="filter__head" data-filter-head>
                            <div class="filter__title">Тип обуви</div>
                            <div class="filter__icon">
                                <svg class="svg-sprite-icon icon-dropdown">
                                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#dropdown"></use>
                                </svg>
                            </div>
                        </div>
                        <div class="filter__content" data-filter-content>
                            <div class="filter__list">
                                @foreach($filter_types as $type)
                                    <label class="checkbox">
                                        <input class="checkbox__input" type="checkbox" name="types[]"
                                               value="{{ $type->id }}"
                                                {{ isset($filter_data['types']) && in_array($type->id, $filter_data['types']) ? 'checked' : null }}
                                        />
                                        <span class="checkbox__box"></span>{{ $type->name }}
                                    </label>
                                @endforeach
                            </div>
                            <div class="filter__action">
                                <button class="filter__submit btn-reset">
                                    <span>Показать</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
    <div class="container__divider"></div>
</div>


