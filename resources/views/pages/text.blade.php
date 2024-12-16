@php $innerPage = true; @endphp
@extends('template')
@section('content')
    <main>
        @include('blocks.bread')
        <section>
            <div class="container">
                <h1 class="section__title centered">{{ $h1 }}</h1>
                <div class="text-content">
                    {!! $text !!}
                </div>
            </div>
        </section>
    </main>
@stop
