Marionette = require 'backbone.marionette'

# Basic layout view of site
module.exports = Marionette.LayoutView.extend {
	template: require '../templates/layout.html'
	regions:
		content: '#content'
}