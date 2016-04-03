/**
 * Home page point entry
 */

require([], function() {
    'use strict';

    require(['routers/home'], function(Router) {
        new Router();

        Backbone.history.start();
    });
});