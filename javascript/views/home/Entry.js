/**
 * Home main view
 */

define(function(require) {
    'use strict';

    /* Libs */
    var Backbone = require('backbone');
    var _ = require('underscore');

    /* Templates */
    var PostTpl = require('text!html/ShortPosts.html');
    var EmptyPostTpl = require('text!html/EmptyPost.html');

    return Backbone.View.extend({
        className: 'home-main',

        template: _.template(PostTpl),
        emptyTemplate: _.template(EmptyPostTpl),

        events: {
            'mouseover .avatar': 'onOverAvatar',
            'mouseout .avatar': 'onOutAvatar'
        },

        initialize: function() {
            this.posts = new Backbone.Collection('posts');

            this.listenTo(this.posts, {
                'read:success': this.onGetPostsSuccess,
                'read:error': this.onGetPostsError,
            });

            this.posts.fetch();
        },

        render: function() {
            if (!this.posts.isEmpty()) {
                this.$el.html(this.template({
                    posts: this.posts
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

        onGetPostsSuccess: function() {
            console.log('Get /posts succeeded');

            this.render();
        },

        onGetPostsError: function() {
            console.log('Get /posts failed');
        },

        onOverAvatar: function(evt) {
            var $elem = $(evt.currentTarget).parent().find('.author');
            
            $elem.fadeIn(200);
        },

        onOutAvatar: function(evt) {
            var $elem = $(evt.currentTarget).parent().find('.author');

            $elem.fadeOut(200);
        }
    });
});