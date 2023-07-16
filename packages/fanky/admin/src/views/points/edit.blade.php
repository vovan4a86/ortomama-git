@extends('admin::template')

@section('scripts')
	<script type="text/javascript" src="/adminlte/interface_points.js"></script>
@stop

@section('page_name')
	<h1>
		Пункт выдачи
		<small>{{ $item->id ? 'Редактировать' : 'Новый' }}</small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li><a href="{{ route('admin.points') }}">Пункты выдачи</a></li>
		<li class="active">{{ $item->id ? 'Редактировать' : 'Новый' }}</li>
	</ol>
@stop

@section('content')
	<form action="{{ route('admin.points.save') }}" onsubmit="return pointsSave(this, event)">
		<input type="hidden" name="id" value="{{ $item->id }}">

		<div class="box box-solid">
			<div class="box-body">
				<div class="form-group">
					<label for="review-name">Название</label>
					<input id="review-name" class="form-control" type="text" name="name" value="{{ $item->name }}">
				</div>

				<div class="form-group">
					<label for="review-address">Адрес</label>
					<input id="review-address" class="form-control" type="text" name="address" value="{{ $item->address }}">
				</div>
			</div>

			<div class="box-footer">
    			<button type="submit" class="btn btn-primary">Сохранить</button>
    		</div>
		</div>
	</form>
@stop