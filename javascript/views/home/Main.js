/**
 * Home main view
 */

define(function(require) {
    'use strict';

    /* Libs */
    var Backbone = require('backbone');
    var _ = require('underscore');

    /* Templates */
    var MainTpl = require('text!html/home/Main');

    return Backbone.View.extend({

        className: 'home-main',

        template: _.template(MainTpl),

        events: {},

        initialize: function() {
            console.log('main initialized');
        },

        render: function() {
            this.$el.html(this.template());

            return this;
        }
    });
});