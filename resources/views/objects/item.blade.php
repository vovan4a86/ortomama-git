@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <section class="s-object">
            <div class="s-object__container container text-block">
                <div class="s-object__title">{{ $name }}</div>
                <div class="s-object__date">{{ $date }}</div>
                <div class="s-object__subtitle">
                    <p>{{ $item->announce }}</p>
                </div>
                <div class="s-object__body">
                    {!! $text !!}
                </div>
                @if(count($images))
                    <div class="s-object__grid">
                        @foreach($images as $img)
                            <a class="s-object__item" href="{{ $img->image_src }}" data-fancybox="gallery"
                               data-caption="{{ $img->name }}">
                                <img class="s-object__pic" src="{{ $img->thumb(2) }}" width="380"
                                     height="250"
                                     alt="{{ $img->name }}">
                            </a>
                        @endforeach
                    </div>
                @endif
                <a href="{{ url()->previous() }}">Назад</a>
            </div>
        </section>
    </main>
@endsection