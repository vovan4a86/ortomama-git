@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="{{ route('admin.catalog') }}"><i class="fa fa-list"></i> Каталог</a></li>
        @foreach($product->getParents($current_catalog, false, true) as $parent)
            <li><a href="{{ route('admin.catalog.products', [$parent->id]) }}">{{ $parent->name }}</a></li>
        @endforeach
        <li class="active">{{ $product->id ? $product->name : 'Новый товар' }}</li>
    </ol>
@stop
@section('page_name')
    <h1>Каталог
        <small style="max-width: 350px;">{{ $product->id ? $product->name : 'Новый товар' }}</small>
    </h1>
@stop

<form action="{{ route('admin.catalog.productSave') }}" onsubmit="return productSave(this, event)">
    {!! Form::hidden('id', $product->id) !!}
    {!! Form::hidden('catalog_id', $current_catalog->id) !!}

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Параметры</a></li>
            <li><a href="#tab_2" data-toggle="tab">Текст ({{ $product->text ? '+' : '-' }})</a></li>
            <li><a href="#tab_chars" data-toggle="tab">Характеристики ({{ $product->chars->count() }})</a></li>
            <li><a href="#tab_filters" data-toggle="tab">Фильтры</a></li>
            <li><a href="#tab_4" data-toggle="tab">Изображения ({{ $product->images()->count() }})</a></li>
            <li><a href="#tab_docs" data-toggle="tab">Документы ({{ $product->docs()->count() }})</a></li>
            <li class="pull-right">
                <a href="{{ route('admin.catalog.products', [$product->catalog_id]) }}"
                   onclick="return catalogContent(this)">К списку товаров</a>
            </li>
            @if($product->id)
                <li class="pull-right">
                    <a href="{{ $product->getUrl($product->catalog_id) }}" target="_blank">Посмотреть</a>
                </li>
            @endif
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                {!! Form::groupText('name', $product->name, 'Название') !!}
                {!! Form::groupText('h1', $product->h1, 'H1') !!}
                {!! Form::groupSelect('selected_catalog_ids[]', $catalogs, $pinned_catalogs, 'Каталог', ['multiple']) !!}
{{--                {!! Form::groupMultiSelect('catalog_id', $catalogs, $pinned_catalogs, 'Каталог') !!}--}}
                {!! Form::groupText('article', $product->article, 'Артикул') !!}
                {!! Form::groupText('size', $product->size, 'Размер') !!}
                {!! Form::groupSelect('brand_id', array_merge([0 => 'Не указано'], $brands), $product->brand_id, 'Бренд') !!}
                {!! Form::groupSelect('color_id', array_merge([0 => 'Не указано'], $colors), $product->color_id, 'Цвет') !!}
                {!! Form::groupText('alias', $product->alias, 'Alias') !!}
                {!! Form::groupText('title', $product->title, 'Title') !!}
                {!! Form::groupText('keywords', $product->keywords, 'keywords') !!}
                {!! Form::groupText('description', $product->description, 'description') !!}
                {!! Form::groupText('price', $product->price ?: 0, 'Цена') !!}
                {!! Form::groupText('old_price', $product->old_price ?: 0, 'Старая цена') !!}

                {!! Form::groupText('discount_delivery', $product->discount_delivery, 'Скидка за самовывоз') !!}
                {!! Form::groupText('discount_payment', $product->discount_payment, 'Скидка по предоплате') !!}

                <hr>
                <label class="control-label">Категории:</label>
                <div style="max-width: 440px;">
                    @foreach($cats as $cat)
                        <input type="checkbox" name="cats[]" id="cat_{{ $cat->id }}" value="{{$cat->id}}"
                                {{ in_array($cat->id, $product_cats) ? 'checked' : '' }}>
                        <label for="cat_{{ $cat->id }}" style="margin-right: 10px;">{{$cat->name}}</label>
                    @endforeach
                </div>
                <hr>
                {!! Form::hidden('in_stock', 0) !!}
                {!! Form::groupCheckbox('published', 1, $product->published, 'Показывать товар') !!}
                {!! Form::groupCheckbox('in_stock', 1, $product->in_stock, 'В наличии') !!}
                {!! Form::groupCheckbox('fss', 1, $product->fss, 'Показывать компенсацию ФСС') !!}
            </div>

            <div class="tab-pane" id="tab_2">
                {!! Form::groupRichtext('text', $product->text, 'Текст', ['rows' => 3]) !!}
            </div>

            <div class="tab-pane" id="tab_chars">
                @include('admin::catalog.product_chars')
            </div>

            <div class="tab-pane" id="tab_filters">
{{--                {!! Form::groupSelect('brand_id', $brands, $product->brand_id, 'Бренд') !!}--}}
                <hr>
{{--                <label class="control-label">Размеры товара:</label>--}}
{{--                <div style="max-width: 440px;">--}}
{{--                    @foreach($sizes as $size)--}}
{{--                        <input type="checkbox" name="sizes[]" id="size_{{ $size->value }}" value="{{$size->id}}"--}}
{{--                                {{ in_array($size->id, $product_sizes) ? 'checked' : '' }}>--}}
{{--                        <label for="size_{{ $size->value }}" style="margin-right: 10px;">{{$size->value}}</label>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
                <hr>
                <label class="control-label">Сезонность:</label>
                <div style="max-width: 440px;">
                    @foreach($seasons as $season)
                        <input type="checkbox" name="seasons[]" id="season_{{ $season->id }}" value="{{$season->id}}"
                                {{ in_array($season->id, $product_seasons) ? 'checked' : '' }}>
                        <label for="season_{{ $season->id }}" style="margin-right: 10px;">{{$season->value}}</label>
                    @endforeach
                </div>
                <hr>
                <label class="control-label">Пол:</label>
                <div style="max-width: 440px;">
                    @foreach($genders as $gender)
                        <input type="checkbox" name="genders[]" id="gender_{{ $gender->id }}" value="{{$gender->id}}"
                                {{ in_array($gender->id, $product_genders) ? 'checked' : '' }}>
                        <label for="gender_{{ $gender->id }}" style="margin-right: 10px;">{{$gender->value}}</label>
                    @endforeach
                </div>
                <hr>
                <label class="control-label">Тип товара:</label>
                @foreach($types as $type)
                    <div>
                        <input type="checkbox" name="types[]" id="type_{{ $type->value }}" value="{{$type->id}}"
                                {{ in_array($type->id, $product_types) ? 'checked' : '' }}>
                        <label for="type_{{ $type->value }}">{{$type->value}}</label>
                    </div>
                @endforeach
            </div>

            <div class="tab-pane" id="tab_4">
                <input id="product-image" type="hidden" name="image" value="{{ $product->image }}">
                @if ($product->id)
                    <div class="form-group">
                        <label class="btn btn-success">
                            <input id="offer_imag_upload" type="file" multiple
                                   data-url="{{ route('admin.catalog.productImageUpload', $product->id) }}"
                                   style="display:none;" onchange="productImageUpload(this, event)">
                            Загрузить изображения
                        </label>
                    </div>
                    <p>Размер изображения: 400x400</p>

                    <div class="images_list">
                        @foreach ($product->images as $image)
                            @include('admin::catalog.product_image', ['image' => $image, 'active' => $product->image])
                        @endforeach
                    </div>
                @else
                    <p class="text-yellow">Изображения можно будет загрузить после сохранения товара!</p>
                @endif
            </div>

            <div class="tab-pane" id="tab_docs">
                @if ($product->id)
                    <div class="form-group">
                        <label class="btn btn-success">
                            <input id="offer_doc_upload" type="file" multiple
                                   accept=".doc, .docx, .pdf"
                                   data-url="{{ route('admin.catalog.productDocUpload', $product->id) }}"
                                   style="display:none;" onchange="productDocUpload(this, event)">
                            Загрузить документы
                        </label>
                    </div>
                    <p>Форматы: .doc, .docx, .pdf</p>

                    <div class="docs_list">
                        @foreach ($product->docs as $doc)
                            @include('admin::catalog.product_doc', ['doc' => $doc])
                        @endforeach
                    </div>
                @else
                    <p class="text-yellow">Документы можно будет загрузить после сохранения товара!</p>
                @endif
            </div>
        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(".images_list").sortable({
        update: function (event, ui) {
            var url = "{{ route('admin.catalog.productImageOrder') }}";
            var data = {};
            data.sorted = $('.images_list').sortable("toArray", {attribute: 'data-id'});
            sendAjax(url, data);
        },
    }).disableSelection();

    $(".docs_list").sortable({
        update: function (event, ui) {
            var url = "{{ route('admin.catalog.productDocOrder') }}";
            var data = {};
            data.sorted = $('.docs_list').sortable("toArray", {attribute: 'data-id'});
            sendAjax(url, data);
        },
    }).disableSelection();
</script>
