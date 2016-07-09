Backbone = require 'backbone'
ImageCollection = require '../collections/image.collection'

Album = Backbone.Model.extend {
	defaults:
		title: ''
		description: ''
		count: 0
		images: new ImageCollection

	url: () ->
		return "/api/album/#{@id}"

	parse: (response) ->
		# Set images collection album identy
		# this need for easy image fetching
		albumId = response.id
		images = new ImageCollection response.images or {}, {albumId}
		response.images = images

		return response
}

module.exports = Album