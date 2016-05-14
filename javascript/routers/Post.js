/**
 * Home page routers
 */

define(function(require) {
    'use strict';

    var Backbone = require('backbone');

    /* Views */
    var Main = require('views/post/Main');
    var Single = require('views/post/Single');

    return Backbone.Router.extend({

        routes: {
            '': 'main',
            'p/:id(/)': 'post',
            'posts(/)': 'postsList'
        },

        main: function() {
            this.postsList();
        },

        post: function() {
            this.show(new Single());
        },

        postsList: function() {
            this.show(new Main());
        },

        show: function(view) {
            $('#app-container').append(view.render().el);
        }

    });
});