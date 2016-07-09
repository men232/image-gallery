Marionette = require 'backbone.marionette'
Router = require './router'
Layout = require './views/layout'

window.app = app = new Marionette.Application {
	initialize: ->
		@options.images = {
			prepage: 10
		}
}

app.on 'before:start', ->
	router = new Router pushState: true

	if Backbone.history
		do Backbone.history.start

do app.start