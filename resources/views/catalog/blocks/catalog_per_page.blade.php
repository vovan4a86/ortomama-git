@if($products_count != 0)
<div class="infos">
    <div class="infos__row">
        <div class="infos__column">
            <div class="infos__label">Товаров:</div>
            <div class="infos__value">{{ $products_count }}</div>
        </div>
        <div class="infos__column">
            <div class="infos__label">Показать:</div>
            <ul class="infos__links">
                @foreach([6, 12, 24, 48, 999] as $n)
                    <li class="infos__item">
                        <a class="infos__link {{ $n == $per_page ? 'infos__link--current' : '' }}"
                           href="{{ url()->current() }}" onclick="selectPerPage({{$n}})"
                           title="Показать {{ $n != 999 ? $n : 'Все' }}">{{ $n != 999 ? $n : 'Все' }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@else
    <div class="infos">
        <h4>Пусто</h4>
    </div>
@endif