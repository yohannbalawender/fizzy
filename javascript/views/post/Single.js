/**
 * Home main view
 */

define(function(require) {
    'use strict';

    /* Libs */
    var Backbone = require('backbone');
    var _ = require('underscore');

    /* Templates */
    var PostTpl = require('text!html/post/Post.html');
    var EmptyPostTpl = require('text!html/post/EmptyPost.html');

    return Backbone.View.extend({
        className: 'post-single',

        template: _.template(PostTpl),
        emptyTemplate: _.template(EmptyPostTpl),    

        initialize: function() {
            this.post = new Backbone.Model('post');

            this.listenTo(this.posts, {
                'read:success': this.onGetPostSuccess,
                'read:error': this.onGetPostError,
            });

            this.post.fetch();
        },

        render: function() {
            if (!this.post.isEmpty()) {
                this.$el.html(this.template({
                    post: this.post
                }));
            } else {
                this.renderEmpty();
            }

            return this;
        },

        renderEmpty: function() {
            this.$el.html(this.emptyTemplate());

            return this;
        },

        onGetPostSuccess: function() {
            console.log('Get /posts succeeded');

            this.render();
        },

        onGetPostError: function() {
            console.log('Get /posts failed');
        }
    });
});