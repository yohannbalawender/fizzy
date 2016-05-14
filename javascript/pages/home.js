/**
 * Home page point entry
 */

require(['common'], function() {
    'use strict';

    require(['routers/Post'], function(Router) {
        new Router();

        Backbone.history.start();
    });
});