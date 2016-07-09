Backbone = require 'backbone'

Image = Backbone.Model.extend {
	defaults:
		title: ''
		description: ''
		createAt: ''
		img_url: ''
		album_id: ''

	url: () ->
		album_id = @get 'album_id'
		return "/api/album/#{album_id}/images/#{@id}"
}

module.exports = Image