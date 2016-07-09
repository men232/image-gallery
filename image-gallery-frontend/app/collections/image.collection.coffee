Marionette = require 'backbone.marionette'
ImageModel = require '../models/image.model'

module.exports = Backbone.Collection.extend {
	initialize: (models, opts) ->
		@albumId = opts?.albumId or -1
		@pagination = 1
		@showPrePage = app?.options.images.prepage or 10

	nextFetch: ->
		@pagination++

	prevFetch: ->
		@pagination--

	fetchPage: (page) ->
		@pagination = page
		#do @fetch

	model: ImageModel
	url: ->
		return "/api/album/#{@albumId}/images/#{@pagination}"
}