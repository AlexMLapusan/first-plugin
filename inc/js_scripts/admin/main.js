( function ( $ ) {

	let frame = wp.media( {
		title: 'Select or Upload Media Of Your Chosen Persuasion',
		button: {
			text: 'Use this media'
		},
		multiple: false  // Set to true to allow multiple files to be selected
	} );

	frame.on( 'select', () => {
		let state = frame.state(),
			selection = state.get( 'selection' );
		selection.forEach( function ( attachment ) {
			$.ajax( {
				type: 'POST',
				url: post_modifier.image_url,
				data: {id: attachment.attributes.id},
				dataType: 'json'
			} ).done( function ( html ) {
				console.log( 'response' );

			} );
		} );
	} );

	let PostContentView = Backbone.View.extend( {
		initialize: function () {
			this.render();
			initSpectrum( {
				target: $( '#header_color' ),
				color: this.model.get( 'header_color' )
			}, ( color ) => {
				this.handleColorChange( 'header_color', color );
			} );
			initSpectrum( {
				target: $( '#content_color' ),
				color: this.model.get( 'content_color' )
			}, ( color ) => {
				this.handleColorChange( 'content_color', color );
			} )
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

			const _html = tpl( 'views/live-preview', {
				post_date: post_modifier.preview.rand_post_date,
				post_title: post_modifier.preview.rand_post_title,
				post_content: post_modifier.preview.rand_post_content
			} );
			this.$el.find( '.actual-preview' ).append( _html );
			this.render();
			this.model.on( 'change:header_color', this.render.bind( this ) );
			this.model.on( 'change:content_color', this.render.bind( this ) );
			this.model.on( 'change:custom_date_format', () => {
				let date = moment( post_modifier.preview.rand_post_date, getMomentFormat( post_modifier.preview.rand_post_date_format ) );
				this.$el.find( '#post-date' ).html( date.format( getMomentFormat( this.model.get( 'custom_date_format' ) ) ) );
			} )
		},
		render: function () {
			this.setTitleColor( this.model.get( 'header_color' ) );
			this.setContentColor( this.model.get( 'content_color' ) );
		},
		setTitleColor: function ( color ) {
			this.$el.find( '#post-title' ).css( 'color', '#' + color );
		},
		setContentColor: function ( color ) {
			this.$el.find( '#post-content' ).css( 'color', '#' + color );
		}
	} );

	let LogoPickerView = Backbone.View.extend( {
		initialize: function () {
			this.$el.find( '.logo-picker' ).append( tpl( 'views/logo-picker' ), {} );
			this.$el.find( '#logo-pick-button' ).click( () => frame.open() );
		},
		render: function () {
		},
	} );

	let Model = Backbone.Model.extend( {url: post_modifier.rest_url} ),
		model = new Model( post_modifier.settings );

	let contentView = new PostContentView( {model: model, el: '.post-content-settings'} ),
		metadataView = new PostMetadataView( {model: model, el: '.post-metadata-settings'} ),
		settings = new SettingsView( {model: model, el: '.post-modifier-settings', attributes: {content: contentView, metadata: metadataView,}} ),
		preview = new PreviewView( {model: model, el: '.live-preview-container'} ),
		logoPicker = new LogoPickerView( {el: '.site-settings-container'} );

	// Create a new media frame

} )( jQuery );