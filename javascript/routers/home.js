/**
 * Home page routers
 */

define(function(require) {
    'use strict';

    var Backbone = require('backbone');
    var MainTpl = require('text!html/home/Main.html');

    /* Views */
    var Main = require('views/home/Main');

    return Backbone.Router.extend({

        routes: {
            '': 'main'
        },

        main: function() {
            this.show(new Main());
        },

        show: function(view) {
            $('#main-app').append(view.render().el);
        }

    });
});