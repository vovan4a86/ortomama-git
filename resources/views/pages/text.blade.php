@php $innerPage = true; @endphp
@extends('template')
@section('content')
    <main>
        @include('blocks.bread')
        <section>
            <div class="container">
                <h2 class="section__title centered">{{ $h1 }}</h2>
                <div class="text-content">
                    {!! $text !!}
                </div>
            </div>
        </section>
    </main>
@stop
