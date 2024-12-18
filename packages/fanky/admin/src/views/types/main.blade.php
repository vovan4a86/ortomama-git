@extends('admin::template')

@section('scripts')
	<script type="text/javascript" src="/adminlte/interface_filters.js"></script>
@stop

@section('page_name')
	<h1>Типы обуви
		<small><a href="{{ route('admin.types.edit') }}">Добавить тип</a></small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Типы обуви</li>
	</ol>
@stop

@section('content')
	<div class="box box-solid">
		<div class="box-body">
			@if (count($types))
				<table class="table table-striped table-v-middle">
					<tbody id="items-list">
						@foreach ($types as $item)
							<tr data-id="{{ $item->id }}">
								<td width="40"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></td>
								<td>{{ $item->name }}</td>
								<td width="50"><a class="glyphicon glyphicon-edit" href="{{ route('admin.types.edit', [$item->id]) }}"
												  style="font-size:20px; color:orange;"></a></td>
								<td width="50">
									<a class="glyphicon glyphicon-trash" href="{{ route('admin.types.del', [$item->id]) }}"
									   style="font-size:20px; color:red;" onclick="itemDel(this, event, 'Удалить тип?')"></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<script type="text/javascript">
					$("#items-list").sortable({
						update: function( event, ui ) {
							var url = "{{ route('admin.types.reorder') }}";
							var data = {};
							data.sorted = ui.item.closest('#items-list').sortable( "toArray", {attribute: 'data-id'} );
							sendAjax(url, data);
						}
					}).disableSelection();
				</script>
			@else
				<p>Нет типов обуви!</p>
			@endif
		</div>
	</div>
@stop