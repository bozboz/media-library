<div data-bind="with: selectedMedia">
  <ul class="secret-list media-browser" data-bind="template: { name: 'media-item-template', foreach: media }"></ul>
</div>

<script>
var data = {{ $data }};
</script>

<script id="media-item-template" type="text/html">
  @include('media-library::fields.partials.media-item')
</script>

<button class="btn btn-info" data-bind="click: mediaLibrary.browse">Browse Media</button>

<div class="modal fade media-modal" id="media-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Browse Media</h4>
      </div>
      <div class="modal-body" data-bind="with: mediaLibrary">
        <ul class="secret-list" data-bind="template: { name: 'media-item-template', foreach: media }"></ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="update-media" data-bind="click: selectedMedia.update">Select Media</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
