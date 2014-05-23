{{ Form::hidden('media') }}

<ul class="secret-list media-browser" id="current-media"></ul>

<script>
var data = {{ $data }};
</script>

<script id="media-item-template" type="text/x-handlebars-template">
@{{#each media}}
  @include('media-library::partials.media-item')
@{{/each}}
</script>

<button class="btn btn-info js-select-media">Browse Media</button>

<div class="modal fade media-modal" id="media-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Browse Media</h4>
      </div>
      <div class="modal-body">
	    <ul class="secret-list"></ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="update-media">Select Media</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
