/**
 * Backbone core module
 */

define('core', ['backbone', 'sync', 'model', 'collection'], function(Backbone, sync) {
    'use strict';

    var backboneSync = Backbone.sync;

    Backbone.sync = function(method, model, options) {
        sync(method, model, options);

        backboneSync(method, model, options);
    }
});

define('model', ['backbone', 'underscore'], function(Backbone, _) {
    'use strict';

    var backboneModel = Backbone.Model;

    var model = function(fullName, attributes, options) {
        this.__url__ = fullName;

        backboneModel.call(this, attributes, options);
    }

    _.extend(model.prototype, Backbone.Model.prototype);

    Backbone.Model = model;
});

define('collection', ['backbone'], function(Backbone) {
    'use strict';

    var backboneCollection = Backbone.Collection;

    var collection = function(fullName, models, options) {
        this.__url__ = fullName;

        backboneCollection.call(this, models, options);
    }

    _.extend(collection.prototype, Backbone.Collection.prototype);

    Backbone.Collection = collection;
});
