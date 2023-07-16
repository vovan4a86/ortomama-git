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
                            <a class="aside__link {{ $cat->isActive ? 'active' : '' }}" href="{{ $cat->url }}" title="{{ $cat->name }}">{{ $cat->name }}</a>
                            @if($cat->public_children)
                                <ul class="aside__sublist {{ $cat->isActive ? 'active' : '' }}">
                                    @foreach($cat->public_children as $children)
                                        <li class="aside__subitem">
                                            <a class="aside__sublink {{ $children->isActive ? 'active' : '' }}" href="{{ $children->url }}"
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
</div>


