@extends('admin::template')

@section('scripts')
	<script type="text/javascript" src="/adminlte/interface_filters.js"></script>
@stop

@section('page_name')
	<h1>
		Пол
		<small>{{ $sex->id ? 'Редактировать' : 'Новый' }}</small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li><a href="{{ route('admin.sexes') }}">Пол</a></li>
		<li class="active">{{ $sex->id ? 'Редактировать' : 'Новый' }}</li>
	</ol>
@stop

@section('content')
	<form action="{{ route('admin.sexes.save') }}" onsubmit="return itemSave(this, event)">
		<input type="hidden" name="id" value="{{ $sex->id }}">

		<div class="box box-solid">
			<div class="box-body">
				{!! Form::groupText('value', $sex->value, 'Название') !!}
			</div>

			<div class="box-footer">
    			<button type="submit" class="btn btn-primary">Сохранить</button>
    		</div>
		</div>
	</form>
@stop