@php $innerPage = true; @endphp
@extends('template')
@section('content')
    <main>
        @include('blocks.bread')
        <section>
            <div class="container">
                <h1 class="section__title centered">{{ $h1 }}</h1>
                <div class="cart__map">
                    <div class="shops">
                        <div class="shops__grid">
                            <div class="shops__data">
                                <div class="shops__title">Выбрать пункт выдачи:</div>
                                @if (count($points))
                                    <div class="shops__select">
                                        <select class="select" name="point" data-map-select>
                                            <!-- https://slimselectjs.com/options-->
                                            @foreach($points as $point)
                                                <option class="select__option"
                                                        value="{{ $point->id }}"
                                                        data-label="{{ $point->address }}"
                                                        data-longitude="{{ $point->longitude }}"
                                                        data-latitude="{{ $point->latitude }}">
                                                    {{ $point->address }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div>Нет пунктов выдачи</div>
                                @endif
                            </div>
                            @if (count($points))
                                <div class="shops__map" id="map" data-map
                                     data-latitude="{{ $points[0]->latitude }}"
                                     data-longitude="{{ $points[0]->longitude }}"
                                     data-label="{{ $points[0]->address }}"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@stop
