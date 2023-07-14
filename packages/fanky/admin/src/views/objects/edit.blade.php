@extends('admin::template')

@section('scripts')
    <script type="text/javascript" src="/adminlte/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/adminlte/plugins/autocomplete/jquery.autocomplete.min.js"></script>
    <script type="text/javascript" src="/adminlte/interface_news.js"></script>
@stop

@section('page_name')
    <h1>
        Объекты
        <small>{{ $object->id ? 'Редактировать' : 'Новая' }}</small>
    </h1>
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="{{ route('admin.objects') }}">Объекты</a></li>
        <li class="active">{{ $object->id ? 'Редактировать' : 'Новая' }}</li>
    </ol>
@stop

@section('content')
    <form action="{{ route('admin.objects.save') }}" onsubmit="return newsSave(this, event)">
        <input type="hidden" name="id" value="{{ $object->id }}">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
                <li><a href="#tab_2" data-toggle="tab">Текст</a></li>
                <li><a href="#tab_3" data-toggle="tab">Галерея</a></li>
                @if($object->id)
                    <li class="pull-right">
                        <a href="{{ route('objects.item', [$object->alias]) }}" target="_blank">Посмотреть</a>
                    </li>
                @endif
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">

                    {!! Form::groupDate('date', $object->date, 'Дата') !!}
                    {!! Form::groupText('name', $object->name, 'Название') !!}
                    {!! Form::groupText('alias', $object->alias, 'Alias') !!}
                    {!! Form::groupText('title', $object->title, 'Title') !!}
                    {!! Form::groupText('keywords', $object->keywords, 'keywords') !!}
                    {!! Form::groupText('description', $object->description, 'description') !!}

                    {!! Form::groupText('og_title', $object->og_title, 'OpenGraph Title') !!}
                    {!! Form::groupText('og_description', $object->og_description, 'OpenGraph description') !!}
                    <div class="form-group">
                        <label for="article-image">Изображение</label>
                        <input id="article-image" type="file" name="image" value=""
                               onchange="return newsImageAttache(this, event)">
                        <div id="article-image-block">
                            @if ($object->image)
                                <img class="img-polaroid" src="{{ $object->thumb(1) }}" height="100"
                                     data-image="{{ $object->image_src }}"
                                     onclick="return popupImage($(this).data('image'))">
                                <a class="images_del" href="{{ route('admin.objects.delete-image', [$object->id]) }}"
                                   onclick="return newsImageDel(this, event)">
                                    <span class="glyphicon glyphicon-trash text-red"></span></a>
                            @else
                                <p class="text-yellow">Изображение не загружено.</p>
                            @endif
                        </div>
                    </div>

                    {!! Form::groupCheckbox('published', 1, $object->published, 'Показывать объект') !!}
                </div>

                <div class="tab-pane" id="tab_2">
                    {!! Form::groupText('city', $object->city, 'Город, дата') !!}
                    {!! Form::groupText('square', $object->square, 'Площадь') !!}
                    {!! Form::groupTextarea('announce', $object->announce, 'Краткое описание', ['rows' => 3]) !!}
                    {!! Form::groupRichtext('text', $object->text, 'Текст', ['rows' => 3]) !!}
                </div>

                <div class="tab-pane" id="tab_3">
                    @if ($object->id)
                        <div class="form-group">
                            <label class="btn btn-success">
                                <input id="offer_imag_upload" type="file" multiple
                                       data-url="{{ route('admin.objects.add_images', $object->id) }}"
                                       style="display:none;" onchange="productImageUpload(this, event)">
                                Загрузить изображения
                            </label>
                        </div>
                        <div class="images_list">
                            @foreach ($object->images as $image)
                                @include('admin::objects.object_image', ['image' => $image])
                            @endforeach
                        </div>
                    @else
                        Загрузить изображения можно после сохранения проекта.
                    @endif

                    <script type="text/javascript">
                        $(".images_list").sortable({
                            update: function (event, ui) {
                                var url = "{{ route('admin.objects.reorder') }}";
                                var data = {};
                                data.sorted = ui.item.closest('.images_list').sortable("toArray", {attribute: 'data-id'});
                                sendAjax(url, data);
                            }
                        }).disableSelection();
                    </script>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </form>
@stop