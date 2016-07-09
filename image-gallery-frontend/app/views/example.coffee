Marionette = require 'backbone.marionette'

# Example landing view
module.exports = Marionette.LayoutView.extend {
	template: require '../templates/example.html'
}