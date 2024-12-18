@extends('admin::template')

@section('scripts')
	<script type="text/javascript" src="/adminlte/interface_filters.js"></script>
@stop

@section('page_name')
	<h1>
		Типы обуви
		<small>{{ $type->id ? 'Редактировать' : 'Новый' }}</small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li><a href="{{ route('admin.types') }}">Типы обуви</a></li>
		<li class="active">{{ $type->id ? 'Редактировать' : 'Новый' }}</li>
	</ol>
@stop

@section('content')
	<form action="{{ route('admin.types.save') }}" onsubmit="return itemSave(this, event)">
		<input type="hidden" name="id" value="{{ $type->id }}">

		<div class="box box-solid">
			<div class="box-body">
				{!! Form::groupText('name', $type->name, 'Название') !!}
			</div>

			<div class="box-footer">
    			<button type="submit" class="btn btn-primary">Сохранить</button>
    		</div>
		</div>
	</form>
@stop