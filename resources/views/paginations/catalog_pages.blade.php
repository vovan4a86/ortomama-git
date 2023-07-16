@if($paginator instanceof \Illuminate\Pagination\LengthAwarePaginator
    && $paginator->hasPages()
    && $paginator->lastPage() > 1)
    <? /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */ ?>

    <?php
    // config
    $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
    $half_total_links = floor($link_limit / 2);
    $from = $paginator->currentPage() - $half_total_links;
    $to = $paginator->currentPage() + $half_total_links;
    if ($paginator->currentPage() < $half_total_links) {
        $to += $half_total_links - $paginator->currentPage();
    }
    if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
        $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
    }
    ?>

    @if ($paginator->lastPage() > 1)
        <div class="pagination">
            <div class="pagination__row">
                @if ($paginator->currentPage() > 1)
                    <a class="pagination__label" href="{{ $paginator->previousPageUrl() }}">Предыдущая</a>
                @endif
                <ul class="pagination__list">
                    @if($from > 1)
                        <li class="pagination__item">
                            <a class="pagination__link" href="{{ $paginator->url(1) }}">
                                <span>1</span>
                            </a>
                        </li>
                    @endif
                    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                        @if ($from < $i && $i < $to)
                            @if ($i == $paginator->currentPage())
                                <li class="pagination__item">
                                    <a class="pagination__link pagination__link--current"
                                       href="{{ $paginator->url($i) }}">
                                        <span>{{ $i }}</span>
                                    </a>
                                </li>
                            @else
                                <li class="pagination__item">
                                    <a class="pagination__link" href="{{ $paginator->url($i) }}">
                                        <span>{{ $i }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endfor

                    @if($to < $paginator->lastPage())
                        <li class="pagination__item">
                            <a class="pagination__link" href="{{ $paginator->url($paginator->lastPage()) }}">
                                <span>...</span>
                            </a>
                        </li>
                    @endif
                </ul>

                @if ($paginator->currentPage() < $paginator->lastPage())
                    <a class="pagination__label" href="{{ $paginator->nextPageUrl() }}">Следующая</a>
                @endif
            </div>
        </div>
    @endif
@endif



