@extends('admin::template')

@section('scripts')
	<script type="text/javascript" src="/adminlte/interface_filters.js"></script>
@stop

@section('page_name')
	<h1>Размеры
		<small><a href="{{ route('admin.sizes.edit') }}">Добавить размер</a></small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Размеры</li>
	</ol>
@stop

@section('content')
	<div class="box box-solid">
		<div class="box-body">
			@if (count($sizes))
				<table class="table table-striped table-v-middle">
					<tbody id="items-list">
						@foreach ($sizes as $item)
							<tr data-id="{{ $item->id }}">
								<td width="40">Размер</td>
								<td>{{ $item->value }}</td>
								<td width="50"><a class="glyphicon glyphicon-edit" href="{{ route('admin.sizes.edit', [$item->id]) }}"
												  style="font-size:20px; color:orange;"></a></td>
								<td width="50">
									<a class="glyphicon glyphicon-trash" href="{{ route('admin.sizes.del', [$item->id]) }}"
									   style="font-size:20px; color:red;" onclick="itemDel(this, event, 'Удалить размер?')"></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<p>Нет размеров!</p>
			@endif
		</div>
	</div>
@stop