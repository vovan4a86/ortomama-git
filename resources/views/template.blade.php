<!DOCTYPE html>
<html lang="ru-RU">
@include('blocks.head')
<body class="no-scroll">
    {!! Settings::get('counters') !!}
    <!-- if !productPage-->
    <div class="v-hidden">
        <h1>Пошив ортопедической обуви</h1>
        <p>Дискрипт заголовка</p>
    </div>
    <div class="preloader">
        <div class="preloader__loader">Загрузка...</div>
    </div>

    @include('blocks.header')

    @if (Route::is('main'))
        <main>
            @yield('content')
        </main>
    @else
        @yield('content')
    @endif

    @include('blocks.footer')
    @include('blocks.popups')

    <div class="v-hidden" itemscope itemtype="https://schema.org/LocalBusiness" aria-hidden="true" tabindex="-1">
        {!! Settings::get('schema.org') !!}
    </div>
    @if(isset($admin_edit_link) && strlen($admin_edit_link))
        <div class="adminedit">
            <div class="adminedit__ico"></div>
            <a href="{{ $admin_edit_link }}" class="adminedit__name" target="_blank">Редактировать</a>
        </div>
    @endif
</body>
</html>
