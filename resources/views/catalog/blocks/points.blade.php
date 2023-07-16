@if (count($points))
    <h2 class="product__subtitle">Пункты выдачи с примеркой</h2>
    <div class="points">
        <div class="points__grid">
            <div class="points__shops">
                @foreach($points as $point)
                    <div class="points__item">
                        <div class="points__name">{{ $point->name }}</div>
                        <div class="points__address">{{ $point->address }}</div>
                    </div>
                @endforeach
            </div>
            <div class="points__links lazy" data-bg="/static/images/common/child.png">
                <a class="points__link" href="javascript:void(0)" title="Все адреса">
                    <span>Все адреса</span>
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.3536 4.85355C14.5488 4.65829 14.5488 4.34171 14.3536 4.14645L11.1716 0.964466C10.9763 0.769204 10.6597 0.769204 10.4645 0.964466C10.2692 1.15973 10.2692 1.47631 10.4645 1.67157L13.2929 4.5L10.4645 7.32843C10.2692 7.52369 10.2692 7.84027 10.4645 8.03553C10.6597 8.2308 10.9763 8.2308 11.1716 8.03553L14.3536 4.85355ZM0 5H14V4H0V5Z"
                              fill="#00B4AB"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endif