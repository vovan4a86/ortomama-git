@extends('admin::template')

@section('scripts')
	<script type="text/javascript" src="/adminlte/interface_filters.js"></script>
@stop

@section('page_name')
	<h1>Пол
		<small><a href="{{ route('admin.genders.edit') }}">Добавить пол</a></small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Пол</li>
	</ol>
@stop

@section('content')
	<div class="box box-solid">
		<div class="box-body">
			@if (count($sexes))
				<table class="table table-striped table-v-middle">
					<tbody id="items-list">
						@foreach ($sexes as $item)
							<tr data-id="{{ $item->id }}">
								<td width="40"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></td>
								<td>{{ $item->value }}</td>
								<td width="50"><a class="glyphicon glyphicon-edit" href="{{ route('admin.genders.edit', [$item->id]) }}"
												  style="font-size:20px; color:orange;"></a></td>
								<td width="50">
									<a class="glyphicon glyphicon-trash" href="{{ route('admin.genders.del', [$item->id]) }}"
									   style="font-size:20px; color:red;" onclick="itemDel(this, event, 'Удалить пол?')"></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<script type="text/javascript">
					$("#items-list").sortable({
						update: function( event, ui ) {
							var url = "{{ route('admin.genders.reorder') }}";
							var data = {};
							data.sorted = ui.item.closest('#items-list').sortable( "toArray", {attribute: 'data-id'} );
							sendAjax(url, data);
						}
					}).disableSelection();
				</script>
			@else
				<p>Нет полов!</p>
			@endif
		</div>
	</div>
@stop