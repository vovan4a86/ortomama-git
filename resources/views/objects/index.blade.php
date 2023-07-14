@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <!--class=(objectsPage && 's-objects--inner')-->
        <section class="s-objects s-objects--inner">
            <div class="s-objects__container container">
                <div class="s-objects__title">{{ $h1 }}</div>
                @if(count($items))
                    <div class="s-objects__grid">
                        @each('objects.list_item', $items, 'item')
                    </div>
                    @include('paginations.links_limit', ['paginator' => $items])
                @endif
            </div>
        </section>
    </main>
@endsection
