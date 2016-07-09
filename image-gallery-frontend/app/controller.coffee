Marionette = require 'backbone.marionette'
LayoutView = require './views/layout'
ExampleView = require './views/example'
AlbumModel = require './models/album.model'
AlbumCollection = require './collections/album.collection'
{AlbumCollectionView, AlbumView} = require './views/album'

Controller = Marionette.Object.extend {
	initialize: ->
		layout = new LayoutView

		@options.layout = layout;
		@options.regionManager = new Marionette.RegionManager {
			regions:
				main: '#app-hook'
		}

		@getOption 'regionManager'
			.get 'main'
			.show layout

	# Dislplay example view
	lading: ->
		view = new ExampleView
		@options.layout.showChildView 'content', view

	# Dislplay album list
	albumsList: ->
		albums = new AlbumCollection

		(do albums.fetch).done =>
			view = new AlbumCollectionView {
				collection: albums
			}

			@options.layout.showChildView 'content', view

	# Dislplay album with images pagination
	showAlbum: (id) ->
		album = new AlbumModel {id}

		(do album.fetch).done =>
			view = new AlbumView {model: album}
			@options.layout.showChildView 'content', view

	# Dislplay album images of spec. page
	showAlbumPage: (id, page) ->
		album = new AlbumModel {id}

		(do album.fetch).done =>
			images = album.get 'images'
			images.fetchPage Number page

			view = new AlbumView {model: album}
			@options.layout.showChildView 'content', view
}

module.exports = Controller