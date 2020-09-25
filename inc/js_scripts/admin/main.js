( function ( $ ) {

	let PostContentView = Backbone.View.extend( {
		initialize: function () {
			this.render();
			$( '#header_color' ).spectrum( {
				color: '#' + this.model.get( 'header_color' ),
				showButtons: false,
			} ).on( 'dragstop.spectrum', ( e, color ) => {
				$(e.currentTarget).spectrum('set', color.toHex());
//				$( '#post-title' ).css( 'color', '#' + color.toHex() );
				this.handleColorChange('header_color', color.toHex());
			} );

			$( '#content_color' ).spectrum( {
				color: '#' + this.model.get( 'content_color' ),
				showButtons: false,
			} ).on( 'dragstop.spectrum',  ( e, color ) => {
				$(e.currentTarget).spectrum('set', color.toHex());
//				$( '#post-content' ).css( 'color', '#' + color.toHex() );
				this.handleColorChange('content_color', color.toHex());
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
//			'change .color-picker': 'handleColorChange',
		},
		handleChange: function ( event ) {
			this.model.set( $( event.target ).attr( 'data-model_attr_name' ), $( event.target ).val() );
		},
		handleColorChange: function ( attr, color ) {
			this.model.set( attr, color );
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

	let SettingsView = Backbone.View.extend( {
		initialize: function () {
			this.render();
		},
		render: function () {
			this.$el.append( this.attributes.content.$el );
			this.$el.append( this.attributes.metadata.$el );
			const _html = tpl( 'views/main' );
			this.$el.append( _html );
		},
		events: {
			'click #save-settings': 'saveSettings',
		},
		saveSettings: function () {
			model.save();
		}
	} );

	let PreviewView = Backbone.View.extend( {
		initialize: function () {
			this.render();
			this.setTitleColor(this.model.get('header_color'));
			this.setContentColor(this.model.get('content_color'));
			this.model.on('change', ()=>{
				this.setTitleColor(this.model.get('header_color'));
				this.setContentColor(this.model.get('content_color'));
			})
		},
		render: function () {
			const _html = tpl( 'views/live-preview', {post_date: 'date', post_title: 'Title', post_content: 'content'} );
			this.$el.find( '.actual-preview' ).append( _html );
			console.log( this.$el.find( '.actual-preview' ).html() );
		},
		setTitleColor: function ( color ){
			this.$el.find('#post-title').css('color', '#' + color);
		},
		setContentColor: function ( color ){
			this.$el.find('#post-content').css('color', '#' + color);
		}
	} );

	let Model = Backbone.Model.extend( {} ),
		Models = Backbone.Collection.extend( {
			model: Model,
			url: post_modifier.rest_url
		} );

	let modelCollection = new Models(),
		model = new Model( post_modifier.settings );

	modelCollection.add( model );

	let contentView = new PostContentView( {model: model, el: '.post-content-settings'} ),
		metadataView = new PostMetadataView( {model: model, el: '.post-metadata-settings'} ),
		settings = new SettingsView( {model: model, el: '.post-modifier-settings', attributes: {content: contentView, metadata: metadataView,}} ),
		preview = new PreviewView( {model: model, el: '.live-preview-container'} );

} )( jQuery );