( function ( $ ) {

	let model = new Backbone.Model( post_modifier.settings );

	let SettingsViewClass = Backbone.View.extend( {
		initialize: function () {
			this.render();
			console.log( this.model.attributes );
			$( '#header_color' ).spectrum( {
				color: '#' + this.model.get( 'header_color' )
			} );
		},
		render: function () {
			const _html = $( "#custom-template" ).html();
			this.$el.html( _.template( _html )( {'option': this.model.get( 'plugin_state' ), 'special_word': this.model.get( 'special_word' )} ) );
		},
		events: {
			'change .state, #special-word ': 'handleChange',
			'change #header_color': 'handleColorChange',
			'click #save-settings': 'saveSettings',
		},
		handleChange: function ( event ) {
			this.model.set( $( event.target ).attr( 'data-model_attr_name' ), $( event.target ).val() );
		},
		handleColorChange: function ( event ) {
			this.model.set( $( event.target ).attr( 'data-model_attr_name' ), $( event.target ).spectrum( "get" ).toHex() );
			console.log( this.model.get( 'header_color' ) );
		},
		saveSettings: function () {

			$.ajax( {
				method: 'POST',
				url: post_modifier.rest_url,
				data: this.model.attributes,
			} ).success( function () {
				alert( "Settings saved" );
			} );
		}
	} )

	let view = new SettingsViewClass( {model: model, el: '.post_modifier-settings'} )

} )( jQuery );