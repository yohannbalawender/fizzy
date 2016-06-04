/**
 * Backbone core module
 */

define('backbone', function(require) {
    'use strict';

    var Backbone = require('extBackbone');
    var sync = require('sync');
    var _ = require('underscore');
    var $ = require('jquery');

    var backboneSync, backboneModel, backboneCollection, backboneView;
    var model, parse, collection, render, view;

    /* Sync */
    backboneSync = Backbone.sync;

    Backbone.sync = function(method, model, options) {
        sync(method, model, options);

        backboneSync(method, model, options);
    }

    /* Model */
    backboneModel = Backbone.Model;

    model = function(fullName, attributes, options) {
        var originalIsEmpty = this.isEmpty;

        this.__url__ = fullName;

        this.id = attributes.id;

        backboneModel.call(this, attributes, options);

        /* Override instance methods */
        this.isEmpty = function() {
            var isEmpty = originalIsEmpty.call(this);

            /* Consider a model with only an id set as empty */
            if (!isEmpty) {
                isEmpty = _.keys(this.attributes).length === 1
                       && !_.isUndefined(this.attributes.id);
            }

            return isEmpty;
        }
    }

    _.extend(model.prototype, Backbone.Model.prototype);

    model.extend = backboneModel.extend;

    Backbone.Model = model;

    /* Collection */
    backboneCollection = Backbone.Collection;

    parse = function(resp, options) {
        if (!_.isArray(resp)) {
            return _.map(resp);
        }

        return resp;
    };

    collection = function(fullName, models, options) {
        this.__url__ = fullName;

        this.parse = parse;

        backboneCollection.call(this, models, options);
    }

    _.extend(collection.prototype, Backbone.Collection.prototype);

    collection.extend = backboneCollection.extend;

    Backbone.Collection = collection;

    /* View */
    render = function() {
        this.$('a[data-bypass]').click(function(evt) {
            var $element = $(evt.currentTarget);
            var href = $element.attr('href');

            evt.preventDefault();

            Backbone.Router.prototype.navigate(href, { trigger: true });
        });

        return this;
    };

    backboneView = Backbone.View;

    view = function() {
        var oldRender = this.render;

        backboneView.apply(this, arguments);

        this.render = function() {
            oldRender.apply(this, arguments);

            render.call(this);

            return this;
        };
    }

    _.extend(view.prototype, Backbone.View.prototype);

    view.extend = backboneView.extend;

    Backbone.View = view;

    return Backbone;
});
