( function ( $ ) {

	let deviceLogoPickerClicked = "";

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
				option: this.model.get( 'plugin_state' ),
				specialWord: this.model.get( 'special_word' ),
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
				dateFormat: this.model.get( 'custom_date_format' )
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
				postDate: post_modifier.preview.rand_post_date,
				postTitle: post_modifier.preview.rand_post_title,
				postContent: post_modifier.preview.rand_post_content,
				desktopSiteLogo: post_modifier.settings.logo_srcs.desktop,
				tabletSiteLogo: post_modifier.settings.logo_srcs.tablet,
				mobileSiteLogo: post_modifier.settings.logo_srcs.mobile,
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
			this.$el.find( '#site-logo' ).attr( 'src', post_modifier.settings.site_logo_src );
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
			this.$el.find( '.logo-picker-button' ).click( ( event ) => {
				deviceLogoPickerClicked = $( event.target ).attr( 'id' );
				frame.open();
			} );
		},
	} );

	let frame = wp.media( {
		title: 'Select or Upload Media Of Your Chosen Persuasion',
		button: {
			text: 'Use this media'
		},
		multiple: false  // Set to true to allow multiple files to be selected
	} );

	frame.on( 'select', function () {
		let attachment = frame.state().get( 'selection' ).first();
		$.ajax( {
			type: 'POST',
			url: post_modifier.image_url + "/" + attachment.attributes.id,
			data: {device: deviceLogoPickerClicked},
			dataType: 'json'
		} ).done( function ( response ) {
			$( '.actual-preview' ).find( '#' + deviceLogoPickerClicked ).attr( 'src', response[ deviceLogoPickerClicked ] );
			logoModels.get( deviceLogoPickerClicked ).set( 'src', response[ deviceLogoPickerClicked ] );
		} );
	} );

	let LogoPickerModel = Backbone.Model.extend( {} ),
		logoModels = new Backbone.Collection();

	for ( const [ key, value ] of Object.entries( post_modifier.settings.logo_srcs ) ) {
		let currentModel = new LogoPickerModel( {src: value} ).set( 'id', key );
		logoModels.push( currentModel );
	}

	let Model = Backbone.Model.extend( {url: post_modifier.rest_url} ),
		model = new Model( post_modifier.settings );

	let contentView = new PostContentView( {model: model, el: '.post-content-settings'} ),
		metadataView = new PostMetadataView( {model: model, el: '.post-metadata-settings'} ),
		settings = new SettingsView( {model: model, el: '.post-modifier-settings', attributes: {content: contentView, metadata: metadataView,}} ),
		preview = new PreviewView( {model: model, el: '.live-preview-container'} ),
		logoPicker = new LogoPickerView( {el: '.site-settings-container'} );

} )( jQuery );
