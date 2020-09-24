( function ( $ ) {

	let PostContentView = Backbone.View.extend( {
		initialize: function () {
			this.render();
			$( '#header_color' ).spectrum( {
				color: '#' + this.model.get( 'header_color' )
			} );
			$( '#content_color' ).spectrum( {
				color: '#' + this.model.get( 'content_color' )
			} );
		},
		render: function () {
			const _html = tpl( 'views/post-content', {
				'option': this.model.get( 'plugin_state' ),
				'special_word': this.model.get( 'special_word' ),
			} );
			this.$el.html( _html );
		},
		events: {
			'change .state, #special-word': 'handleChange',
			'change .color-picker': 'handleColorChange',
		},
		handleChange: function ( event ) {
			this.model.set( $( event.target ).attr( 'data-model_attr_name' ), $( event.target ).val() );
		},
		handleColorChange: function ( event ) {
			this.model.set( $( event.target ).attr( 'data-model_attr_name' ), $( event.target ).spectrum( 'get' ).toHex() );
		}
	} )

	let PostMetadataView = Backbone.View.extend( {
		initialize: function () {
			this.render();
		},
		render: function () {
			const _html = tpl( 'views/post-metadata', {
				'date_format': this.model.get( 'custom_date_format' )
			} );
			this.$el.html( _html );
//			console.log(this.$el.html);
		},
		events: {
			'change #custom_date_format': 'handleChange',
		},
		handleChange: function ( event ) {
			this.model.set( $( event.target ).attr( 'data-model_attr_name' ), $( event.target ).val() );
		}
	} )

	let MainView = Backbone.View.extend( {
		initialize: function () {
			this.render();
		},
		render: function () {
			this.$el.append( this.attributes.content.$el );
			this.$el.append( this.attributes.metadata.$el );
			const _html = tpl( 'views/main');
			this.$el.append( _html );
		},
		events: {
			'click #save-settings': 'saveSettings',
		},
		saveSettings: function () {
			model.save();
		}
	} );
	let Model = Backbone.Model.extend({}),
		Models = Backbone.Collection.extend({
		model: Model,
		url: post_modifier.rest_url
	})

	let modelCollection = new Models(),
	model = new Model( post_modifier.settings );
	modelCollection.add(model);

	let contentView = new PostContentView( {model: model, el: '.post-content-settings'} ),
	metadataView = new PostMetadataView( {model: model, el: '.post-metadata-settings'} ),
	main = new MainView( {model: model, el: '.post_modifier-settings', attributes: {content: contentView, metadata: metadataView,}} );

} )( jQuery );