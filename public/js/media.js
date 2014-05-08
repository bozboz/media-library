var media;
var mediaModal = $('#media-modal');
var mediaField = $('#current-media');
var itemTpl = $('#media-item-template').html();

$('.js-select-media').on('click', function(e) {
	if (!media) {
		$.getJSON('/admin/media', {media: []}, function(response) {
			media = response;
			var template = Handlebars.compile(itemTpl);
			var masonryContainer = $('#media-modal .modal-body ul').html(template(media));

			mediaModal.on('show.bs.modal', function() {
				$('#media-modal input[name="media[]"]').each(function() {
					if (!$('#media-' + this.value).is(':checked')) {
						$(this).removeAttr('checked');
					}
				});
			});

			mediaModal.on('shown.bs.modal', function (e) {
				masonryContainer.masonry({
					columnWidth: 187,
					itemSelector: ".masonry-item"
				});
				masonryContainer.imagesLoaded( function() {
					masonryContainer.masonry();
				});
			});

			mediaModal.modal('show');
		});
	} else {
		mediaModal.modal('show');
	}
	e.preventDefault();
});

$('#update-media').on('click', function(e) {
	data = [];
	mediaModal.modal('hide');
	$('#media-modal input:checked').each(function(i) {
		var li = $(this).parent();
		data.push({
			id: li.data('id'),
			caption: li.data('caption'),
			filename: li.data('filename')
		});
	});
	var template = Handlebars.compile(itemTpl);
	var container = mediaField.html(template({media: data}));
	e.preventDefault();
});

var template = Handlebars.compile(itemTpl);
mediaField.html(template(data));
