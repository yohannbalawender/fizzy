/**
 * Common module
 */

define(function(require) {
    'use strict';

    var _ = require('underscore');
    var $ = require('jquery');

    return function sync(method, model, options) {
        var success = options.success || $.noop;
        var error = options.error || $.noop;

        options.url = 'req/' + model.__url__;

        if (model.id) {
            options.url += '/' + model.id;
        }

        options.success = function() {
            var response;

            success.apply(this, arguments);

            response = arguments[0];

            model.trigger(method + ':success', model, response);
        }

        options.error = function() {
            error.apply(this, arguments);

            /* Todo, what's important here to give ? */
            model.trigger(method + ':error');
        }
    };
});
