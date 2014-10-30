function MediaViewModel(data)
{
	var self = this;

	this.aliases = data.aliases;

	this.selectedMedia = {
		mediaPath: data.mediaPath,
		media: ko.observableArray(data.media),
		fieldId: 'media',
		getFilename: function(filename)
		{
			return this.mediaPath + '/' + filename;
		},
		update: function()
		{
			var mediaLibrary = self.mediaLibrary.media();
			self.selectedMedia.media(ko.utils.arrayFilter(mediaLibrary, function(media) {
				return media.selected;
			}));
			mediaModal.modal('hide');
		}
	};

	this.mediaLibrary = {
		loaded: ko.observable(false),
		media: ko.observableArray([]),
		fieldId: 'library',
		getFilename: function(filename)
		{
			return this.mediaPath + '/' + filename;
		},
		browse: function()
		{
			if (!self.mediaLibrary.loaded()) {
				$.getJSON('/admin/media', function(data)
				{
					ko.utils.arrayForEach(self.selectedMedia.media(), function(selectedMedia) {
						var item = ko.utils.arrayFirst(data.media, function(media) {
							return media.id === selectedMedia.id;
						});
						item.selected = true;
						item.alias = selectedMedia.alias;
					});

					self.mediaLibrary.mediaPath = data.mediaPath;
					self.mediaLibrary.media(data.media);

					var masonryContainer = $('#media-modal .modal-body ul');

					mediaModal.on('shown.bs.modal', function (e) {
						masonryContainer.masonry({
							columnWidth: 187,
							itemSelector: ".masonry-item"
						});
						masonryContainer.imagesLoaded( function() {
							masonryContainer.masonry();
						});
					});

					self.mediaLibrary.loaded(true);
					mediaModal.modal('show');
				});
			} else {
				mediaModal.modal('show');
			}
		}
	};
}

$('.media-browser').sortable({
	placeholder: '<li class="placeholder masonry-item"></li>'
});

if (typeof data !== 'undefined') {
	var mediaModal = $('#media-modal');
	var viewModel = new MediaViewModel(data);
	ko.applyBindings(viewModel);
}
