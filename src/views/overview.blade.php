@extends('admin::overview')

@section('main')
	@include('admin::partials.new')
	<h1>{{ $modelName }}</h1>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
			</thead>

	@foreach ($instances as $i => $model)
		<tr>
		@foreach ($columns[$i] as $name => $value)
			<td>{{ $value }}</td>
		@endforeach
			<td class="no-wrap">
	 	 		{{ Form::model($model, array('action' => array($controller . '@destroy', $model->id), 'method' => 'DELETE')) }}
		 			<a class="btn btn-primary btn-sm" href="/admin/pages/{{ $model->id }}/edit"><i class="fa fa-pencil"></i> Edit</a>
	 	 			<button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-minus-square"></i> Delete</button>
	 			{{ Form::close() }}
		 	</td>
		</tr>
	@endforeach 
		</table>
	</div>
	@include('admin::partials.new')
@stop
