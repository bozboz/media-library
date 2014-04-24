@extends('admin::overview')

@section('styles')
@parent
	<link rel="stylesheet" href="/packages/bozboz/media-library/css/media-library.css">
@stop

@section('main')
	@include('admin::partials.new')
	<h1>{{ $modelName }}</h1>
	<ul class="js-masonry secret-list" data-masonry-options='{ "columnWidth": 187, "itemSelector": ".masonry-item" }'>
	@foreach ($instances as $i => $model)
		<li class="masonry-item">
			<a href="{{ URL::action($controller . '@edit', array($model->id)) }}">
				{{ $columns[$i]['image'] }}
			</a>
			<div class="icons">
				<a href="{{ URL::action($controller . '@edit', array($model->id)) }}" class="btn btn-info btn-sm pull-right">
					<i class="fa fa-pencil"></i>
					Edit
				</a>

				{{ Form::model($model, array('class' => 'inline-form', 'action' => array($controller . '@destroy', $model->id), 'method' => 'DELETE')) }}
					<button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-minus-square"></i> Delete</button>
				{{ Form::close() }}
			</div>
		</li>
	@endforeach
	</ul>
	@include('admin::partials.new')
@stop

@section('scripts')
@parent
	<script src="/packages/bozboz/media-library/js/masonry.js"></script>
@stop
