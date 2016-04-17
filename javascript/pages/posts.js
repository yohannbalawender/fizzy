/**
 * Home page point entry
 */

require(['common'], function() {
    'use strict';

    require(['routers/home'], function(Router) {
        new Router();

        Backbone.history.start();
    });
});