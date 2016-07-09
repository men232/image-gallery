Marionette = require 'backbone.marionette'
AlbumModel = require '../models/album.model'

module.exports = Backbone.Collection.extend {
	url: '/api/album'
	model: AlbumModel
}