@extends('admin::layouts.default')

@section('main')
@parent

{{ Form::open(['url' => route('admin.media.update', ['id' => $media->id]), 'method' => $method]) }}

	<div class="form-row discrete">
		@include('admin::partials.save')
	</div>

	<h2>@yield('heading')</h2>
	@foreach($mediaFields as $field)
	 <div class="form-group{{{ ($field->getErrors($errors)) ? ' bs-callout bs-callout-danger' : '' }}}">
		{{ $field->getLabel() }}
		{{ $field->getInput($media) }}
		{{ $field->getErrors($errors) }}
	</div>

	@endforeach

	@foreach($metadataFields as $field)
	 <div class="form-group{{{ ($field->getErrors($errors)) ? ' bs-callout bs-callout-danger' : '' }}}">
		{{ $field->getLabel() }}
		{{ $field->getInput($metadata) }}
		{{ $field->getErrors($errors) }}
	</div>

	@endforeach

	<div class="form-row">
		@include('admin::partials.save')
	</div>
{{ Form::close() }}

@stop
