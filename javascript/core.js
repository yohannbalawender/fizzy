/**
 * Backbone core module
 */

define('core', ['backbone', 'sync', 'model', 'collection', 'render'], function(Backbone, sync) {
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

        this.id = attributes.id;

        backboneModel.call(this, attributes, options);
    }

    _.extend(model.prototype, Backbone.Model.prototype);

    Backbone.Model = model;

    return model;
});

define('collection', ['backbone', 'underscore'], function(Backbone, _) {
    'use strict';

    var backboneCollection = Backbone.Collection;

    var parse = function(resp, options) {
        if (!_.isArray(resp)) {
            return _.map(resp);
        }

        return resp;
    };

    var collection = function(fullName, models, options) {
        this.__url__ = fullName;

        this.parse = parse;

        backboneCollection.call(this, models, options);
    }

    _.extend(collection.prototype, Backbone.Collection.prototype);

    Backbone.Collection = collection;

    return collection;
});

define('render', ['backbone', 'jquery'], function(Backbone, $) {
    'use strict';

    var backboneRender = Backbone.View.prototype.render;

    var render = function() {
        backboneRender();

        $('a[data-bypass]').click(function(evt) {
            evt.preventDefault();

            console.log('click');
        });

        return this;
    };

    Backbone.View.prototype.render = render;

    return render;
});
