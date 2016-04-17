/**
 * Home page routers
 */

define(function(require) {
    'use strict';

    var Backbone = require('backbone');

    /* Views */
    var Entry = require('views/home/Entry');

    return Backbone.Router.extend({

        routes: {
            '': 'main'
        },

        main: function() {
            this.show(new Entry());
        },

        show: function(view) {
            $('#app-container').append(view.render().el);
        }

    });
});