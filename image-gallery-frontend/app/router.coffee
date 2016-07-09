Marionette = require 'backbone.marionette'
Controller = require './controller'
Router = Marionette.AppRouter.extend {
	controller: new Controller
	appRoutes:
		'': 'lading'
		'albums': 'albumsList'
		'album/:id': 'showAlbum'
		'album/:id/page/:page': 'showAlbumPage'
	}

module.exports = Router;