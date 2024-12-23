<table>
    <thead>
    <tr>
        <th width="8">ID</th>
        <th>Уровень 1</th>
        <th>Уровень 2</th>
        <th>Уровень 3</th>
        <th>Уровень 4</th>
        <th>Уровень 5</th>
        <th width="40">Название</th>

        <th>Размер</th>
        <th>Стенка</th>
        <th>Сталь</th>

        <th>Тип</th>
        <th>Бренд</th>
        <th>Модель</th>
        <th>Диаметр</th>
        <th>РУ</th>
        <th>Коммент.</th>
        <th>ГОСТ</th>


        <th>Измер. 1</th>
        <th>Измер. 2</th>

        <th>Цена, т</th>
        <th>Цена, шт</th>
        <th>Цена, м</th>
        <th>Цена, кг</th>
        <th>Цена, м2</th>
        <th>Цена, уп</th>
        <th>Цена, тыс.шт</th>
        <th>Цена, км</th>
        <th>Наличие</th>
        <th width="12">Доп.разделы</th>
        <th>Длина</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        @php
            $_parents = $item->getParents(false,true);
            $parent1 = array_get($_parents, 0);
		    $parent2 = array_get($_parents, 1);
		    $parent3 = array_get($_parents, 2);
		    $parent4 = array_get($_parents, 3);
		    $parent5 = array_get($_parents, 4);
        @endphp
        <tr>
            <td style="text-align: left;">{{$item->id}}</td>
            <td style="text-align: left;">{{ $parent1 ? $parent1->name: '' }}</td>
            <td style="text-align: left;">{{ $parent2 ? $parent2->name: '' }}</td>
            <td style="text-align: left;">{{ $parent3 ? $parent3->name: '' }}</td>
            <td style="text-align: left;">{{ $parent4 ? $parent4->name: '' }}</td>
            <td style="text-align: left;">{{ $parent5 ? $parent5->name: '' }}</td>
            <td style="text-align: left;">{{$item->name}}</td>

            <td style="text-align: left;">{{$item->size}}</td>
            <td style="text-align: left;">{{$item->wall}}</td>
            <td style="text-align: left;">{{$item->steel}}</td>

            <td style="text-align: left;">{{$item->type}}</td>
            <td style="text-align: left;">{{$item->brand}}</td>
            <td style="text-align: left;">{{$item->model}}</td>
            <td style="text-align: left;">{{$item->diameter}}</td>
            <td style="text-align: left;">{{$item->py}}</td>
            <td style="text-align: left;">{{$item->comment}}</td>
            <td style="text-align: left;">{{$item->gost}}</td>

            <td style="text-align: left;">{{$item->measure}}</td>
            <td style="text-align: left;">{{$item->measure2}}</td>

            <td style="text-align: left;">{{$item->price}}</td>
            <td style="text-align: left;">{{$item->price_per_item ?: ''}}</td>
            <td style="text-align: left;">{{$item->price_per_metr ?: ''}}</td>
            <td style="text-align: left;">{{$item->price_per_kilo ?: ''}}</td>
            <td style="text-align: left;">{{$item->price_per_m2 ?: ''}}</td>
            <td style="text-align: left;">{{$item->price_per_pack ?: ''}}</td>
            <td style="text-align: left;">{{$item->price_per_thousand ?: ''}}</td>
            <td style="text-align: left;">{{$item->price_per_km ?: ''}}</td>
            <td style="text-align: left;">{{$item->in_stock}}</td>
            <td style="text-align: left;">{{ implode(',', $item->additional_catalogs->pluck('id')->toArray()) }}</td>
            <td style="text-align: left;">{{$item->length}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
