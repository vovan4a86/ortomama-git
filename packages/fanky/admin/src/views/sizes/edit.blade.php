@extends('admin::template')

@section('scripts')
	<script type="text/javascript" src="/adminlte/interface_filters.js"></script>
@stop

@section('page_name')
	<h1>
		Размеры
		<small>{{ $size->id ? 'Редактировать' : 'Новый' }}</small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li><a href="{{ route('admin.sizes') }}">Размеры</a></li>
		<li class="active">{{ $size->id ? 'Редактировать' : 'Новый' }}</li>
	</ol>
@stop

@section('content')
	<form action="{{ route('admin.sizes.save') }}" onsubmit="return itemSave(this, event)">
		<input type="hidden" name="id" value="{{ $size->id }}">

		<div class="box box-solid">
			<div class="box-body">
				{!! Form::groupText('value', $size->value, 'Размер') !!}
			</div>

			<div class="box-footer">
    			<button type="submit" class="btn btn-primary">Сохранить</button>
    		</div>
		</div>
	</form>
@stop