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
			const _html = $( '#post-content-template' ).html();
			this.$el.html( _.template( _html )( {
				'option': this.model.get( 'plugin_state' ),
				'special_word': this.model.get( 'special_word' ),
			} ) );
			console.log( this.$el.html() );
		},
		events: {
			'change .state, #special-word': 'handleChange',
			'change .color-picker': 'handleColorChange',
		},
		handleChange: function ( event ) {
			this.model.set( $( event.target ).attr( 'data-model_attr_name' ), $( event.target ).val() );
		},
		handleColorChange: function ( event ) {
			this.model.set( $( event.target ).attr( 'data-model_attr_name' ), $( event.target ).spectrum( "get" ).toHex() );
		}
	} )

	let PostMetadataView = Backbone.View.extend( {
		initialize: function () {
			this.render();
		},
		render: function () {
			const _html = $( "#post-metadata-template" ).html();
			this.$el.html( _.template( _html )( {
				'date_format': this.model.get( 'custom_date_format' )
			} ) );
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
			this.$el.append( this.attributes.content.$el )
			this.$el.append( this.attributes.metadata.$el )
			const _html = $( "#main-template" ).html();
			this.$el.append(_html) ;
		},
		events: {
			'click #save-settings': 'saveSettings',
		},
		saveSettings: function () {
			console.log( 'sent' );
			$.ajax( {
				method: 'POST',
				url: post_modifier.rest_url,
				data: this.model.attributes,
			} ).success( function () {
				alert( "Settings saved" );
			} );
		}
	} );

	let model = new Backbone.Model( post_modifier.settings );
	console.log( $( '.post-content-settings' ) );
	let contentView = new PostContentView( {model: model, el: '.post-content-settings'} );
	let metadataView = new PostMetadataView( {model: model, el: '.post-metadata-settings'} );
	let main = new MainView( {model: model, el: '.post_modifier-settings', attributes: {content: contentView, metadata: metadataView,}} );

//	let view = new SettingsViewClass( {model: model, el: '.post_modifier-settings'} )
//	let mainView = new SettingsViewClass( {model: model, el: '.post_modifier-settings'} )

} )( jQuery );