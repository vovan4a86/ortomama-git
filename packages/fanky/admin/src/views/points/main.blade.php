@extends('admin::template')

@section('scripts')
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="/adminlte/interface_points.js"></script>
@stop

@section('page_name')
	<h1>Пункты выдачи
		<small><a href="{{ route('admin.points.edit') }}">Добавить пункт</a></small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Пункты выдачи</li>
	</ol>
@stop

@section('content')
	<div class="box box-solid">
		<div class="box-body">
			@if (count($points))
				<table class="table table-striped table-v-middle">
					<tbody id="points-list">
						@foreach ($points as $item)
							<tr data-id="{{ $item->id }}">
								<td width="40"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></td>
								<td width="250">{{ $item->name }}</td>
								<td>{{ $item->address }}</td>
								<td width="50"><a class="glyphicon glyphicon-edit" href="{{ route('admin.points.edit', [$item->id]) }}" style="font-size:20px; color:orange;"></a></td>
								<td width="50">
									<a class="glyphicon glyphicon-trash" href="{{ route('admin.points.delete', [$item->id]) }}" style="font-size:20px; color:red;" onclick="pointsDel(this, event)"></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<script type="text/javascript">
					$("#points-list").sortable({
						update: function( event, ui ) {
							var url = "{{ route('admin.points.reorder') }}";
							var data = {};
							data.sorted = ui.item.closest('#points-list').sortable( "toArray", {attribute: 'data-id'} );
							sendAjax(url, data);
						}
					}).disableSelection();
				</script>
			@else
				<p>Нет пунктов выдачи</p>
			@endif
		</div>
	</div>
@stop