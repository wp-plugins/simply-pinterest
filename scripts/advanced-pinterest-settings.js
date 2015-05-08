/*
This is the part of the script that is used in the editor for advanced pinterest settings
 */

(function( $, wp, _ ) {
	var AdvancedPinterestSettingsView, frame;

	if ( ! wp.media.events ) {
		return;
	}

	function addAdvancedPinterestSettingsView( view ) {
		var advancedView;

		advancedView = new AdvancedPinterestSettingsView( { model: view.model } );

		view.on( 'post-render', function() {
			view.views.insert( view.$el.find('.advanced-settings'), advancedView.render().el );
		} );
	}

	wp.media.events.on( 'editor:image-edit', function( options ) {
		var dom = options.editor.dom,
			image = options.image,
			attributes;

		attributes = {
			nopin: dom.getAttrib( image, 'nopin' ),
            pinhover: dom.getAttrib( image, 'data-bpp-pinhover')
		};

		options.metadata = _.extend( options.metadata, attributes );
	} );

	wp.media.events.on( 'editor:frame-create', function( options ) {
		frame = options.frame;
		frame.on( 'content:render:image-details', addAdvancedPinterestSettingsView );
	} );

	wp.media.events.on( 'editor:image-update', function( options ) {
		var editor = options.editor,
			dom = editor.dom,
			image  = options.image,
			model = frame.content.get().model,
            nopin = model.get('nopin'),
			pinhover = model.get('pinhover');

        if ( nopin ) {
            dom.setAttrib( image, 'nopin', 'nopin' );
        } else {
            dom.setAttrib( image, 'nopin', null );
        }

		if ( pinhover ) {
            dom.setAttrib( image, 'data-bpp-pinhover', pinhover );
		} else {
            dom.setAttrib( image, 'data-bpp-pinhover', null );
        }

	} );

	AdvancedPinterestSettingsView = wp.Backbone.View.extend( {
		className: 'advanced-pinterst-settings',
		template: wp.media.template('advanced-pinterst-settings'),

		initialize: function() {
			wp.Backbone.View.prototype.initialize.apply( this, arguments );
		},

		prepare: function() {
			var data = this.model.toJSON();
			return data;
		},

		render: function() {
			wp.Backbone.View.prototype.render.apply( this, arguments );
			return this;
		}
	} );

})( jQuery, wp, _ );
