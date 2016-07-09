Marionette = require 'backbone.marionette'
ImageCollection = require '../collections/image.collection'

# View of single image
ImageView = Marionette.LayoutView.extend {
	template: require '../templates/album.image.html'

	imageDelete: () ->
		do @model.destroy

	ui:
		delete: '.image-delete'

	events:
		'click @ui.delete': 'imageDelete'
}

# View of images list
ImageListView = Marionette.CollectionView.extend {
	childView: ImageView
}

# View of album with images
AlbumView = Marionette.LayoutView.extend {
	template: require '../templates/album.layout.html'
	regions:
		images: '.album-images'

	onShow: ->
		# Load and display images of album
		images = @model.get 'images'
		view = new ImageListView collection: images

		(do images.fetch).done =>
			@showChildView 'images', view
}

# View of album list element
AlbumItemView = Marionette.LayoutView.extend {
	template: require '../templates/album.item.html'

	deleteAlbum: () ->
		do @model.destroy

	ui:
		delete: '.album-delete'

	events:
		'click @ui.delete': 'deleteAlbum'
}

# View of album list
AlbumCollectionView = Marionette.CollectionView.extend {
	childView: AlbumItemView
}

# Export views
module.exports = {
	AlbumView,
	AlbumItemView,
	AlbumCollectionView,
	ImageView,
	ImageListView
}