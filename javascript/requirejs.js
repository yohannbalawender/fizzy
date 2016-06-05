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
            extBackbone: '../ext/backbone/backbone',
            text: '../ext/require-plugins/lib/text',
            json: '../ext/require-plugins/src/json',
            common: 'common'
        },
        shim: {
            'extBackbone': {
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
