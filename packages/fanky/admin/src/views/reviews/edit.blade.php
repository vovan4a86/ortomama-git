@extends('admin::template')

@section('scripts')
	<script type="text/javascript" src="/adminlte/interface_reviews.js"></script>
@stop

@section('page_name')
	<h1>
		Отзывы
		<small>{{ $review->id ? 'Редактировать' : 'Новый' }}</small>
	</h1>
@stop

@section('breadcrumb')
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li><a href="{{ route('admin.reviews') }}">Отзывы</a></li>
		<li class="active">{{ $review->id ? 'Редактировать' : 'Новый' }}</li>
	</ol>
@stop

@section('content')
	<form action="{{ route('admin.reviews.save') }}" onsubmit="return reviewsSave(this, event)">
		<input type="hidden" name="id" value="{{ $review->id }}">

		<div class="box box-solid">
			<div class="box-body">

				<div class="form-group">
					<label for="review-name">Имя, должность</label>
					<input id="review-name" class="form-control" type="text" name="name" value="{{ $review->name }}">
				</div>

				<div class="form-group">
					<label for="review-text">Текст</label>
					<textarea id="review-text" class="form-control" name="text" rows="6">{{ $review->text }}</textarea>
				</div>

				<div class="form-group" style="display: flex; column-gap: 30px;">
					<div>
						<label for="review-image">Изображение</label>
						<input id="review-image" type="file" name="image" value=""
							   onchange="return reviewImageAttache(this, event)">
						<div id="review-image-block">
							@if ($review->image)
								<img class="img-polaroid"
									 src="{{ \Fanky\Admin\Models\Review::UPLOAD_URL . $review->image }}" height="100"
									 data-image="{{ \Fanky\Admin\Models\Review::UPLOAD_URL . $review->image }}"
									 onclick="return popupImage($(this).data('image'))">
							@else
								<p class="text-yellow">Изображение не загружено.</p>
							@endif
						</div>
					</div>
				</div>

				{!! Form::hidden('published', 0) !!}
				{!! Form::groupCheckbox('published', 1, $review->published, 'Показывать') !!}
				{!! Form::hidden('on_main', 0) !!}
				{!! Form::groupCheckbox('on_main', 1, $review->on_main, 'Показывать на главной') !!}

			</div>

			<div class="box-footer">
    			<button type="submit" class="btn btn-primary">Сохранить</button>
    		</div>
		</div>
	</form>
@stop