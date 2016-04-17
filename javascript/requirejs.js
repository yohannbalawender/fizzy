/**
 * Requirejs config
 */

(function(require) {
    'use strict';

    require.config({
        baseUrl: '../javascript/',
        paths: {
            underscore: '../ext/underscore/underscore',
            jquery: '../ext/jquery/jquery-1.8.2.min',
            backbone: '../ext/backbone/backbone',
            text: '../ext/require-plugins/lib/text',
            json: '../ext/require-plugins/src/json',
            common: 'common'
        },
        shim: {
            'backbone': {
                deps: ['jquery', 'underscore'],
                exports: 'Backbone'
            },
            'underscore': {
                exports: '_'
            },
            'jquery': {
                exports: '$'
            }
        }
    });

})(require);
