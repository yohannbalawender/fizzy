/**
 * Navigation bar view
 */

define(function(require) {
    'use strict';

    /* Libs */
    var Backbone = require('backbone');
    var _ = require('underscore');

    /* Templates */
    var MainTpl = require('text!html/nav/Main');

    return Backbone.View.extend({

        className: 'nav-main',

        template: _.template(MainTpl),

        events: {},

        initialize: function() {
            console.log('nav initialized');
        },

        render: function() {
            this.$el.html(this.template());

            return this;
        }
    });
});