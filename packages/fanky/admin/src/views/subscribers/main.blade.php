@extends('admin::template')

@section('scripts')
    <script type="text/javascript" src="/adminlte/interface_filters.js"></script>
@stop

@section('page_name')
    <h1>Подписчики
        <small><a href="{{ route('admin.subscribers.edit') }}">Добавить подписчика</a></small>
    </h1>
@stop

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Подписчики</li>
    </ol>
@stop

@section('content')
    <div class="box box-primary box-solid">
        <div class="box-header"><h2 class="box-title">Подписчики</h2></div>
        <div class="box-body">
            <table class="table table-striped table-hover">
                <thead>
                    <th>Email</th>
                    <th>Дата</th>
                </thead>
                <tbody>
                @foreach($subscribers as $item)
                    <tr>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                        <td width="50"><a class="glyphicon glyphicon-edit" href="{{ route('admin.subscribers.edit', [$item->id]) }}"
                                          style="font-size:20px; color:orange;"></a></td>
                        <td width="50">
                            <a class="glyphicon glyphicon-trash" href="{{ route('admin.subscribers.del', [$item->id]) }}"
                               style="font-size:20px; color:red;" onclick="itemDel(this, event, 'Удалить подписчика?')"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            {!! $subscribers->render() !!}
        </div>
    </div>
@stop