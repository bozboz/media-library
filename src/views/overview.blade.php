@extends('admin::overview')

@section('main')
	@include('admin::partials.new')
	<h1>{{ $modelName }}</h1>
	<ul class="js-mason secret-list">
	@foreach ($report->getRows() as $row)
		<li class="masonry-item">
			<a href="{{ URL::action($controller . '@edit', array($row->getId())) }}">
				{{ $row->getColumns()['image'] }}
			</a>
			<div class="icons">
				<a href="{{ URL::action($controller . '@edit', array($row->getId())) }}" class="btn btn-info btn-sm pull-right">
					<i class="fa fa-pencil"></i>
					Edit
				</a>

				{{ Form::model($row->getModel(), array('class' => 'inline-form', 'action' => array($controller . '@destroy', $row->getId()), 'method' => 'DELETE')) }}
					<button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-minus-square"></i> Delete</button>
				{{ Form::close() }}
			</div>
		</li>
	@endforeach
	</ul>
	@include('admin::partials.new')
@stop
