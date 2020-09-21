( function ( $ ) {

	//todo remove console.logs in JS
	console.log( dash_adder.settings );

	let model = new Backbone.Model( dash_adder.settings );

	let SettingsViewClass = Backbone.View.extend( {
		initialize: function () {
			this.render();
		},
		render: function () {
			const _html = $( "#custom-template" ).html();
			this.$el.html( _.template( _html )( {'option': this.model.get( 'plugin_state' ), 'special_word': this.model.get( 'special_word' )} ) );
		},
		events: {
			'change ': 'handleChange',
//			'change #special-word': 'handleChange',
			'click #save-settings': 'saveSettings',
		},
		handleChange: function ( event ) {
			this.model.set( $(event.target).attr('model_attr_name'), $(event.target).val() );
		},
		saveSettings: function () {

			$.ajax( {
				method: 'POST',
				url: dash_adder.rest_url,
				data:
					{'test': 'aaa'}, //todo re-add 'state' and 'special_word'
			} ).success( function () {
				alert( "Settings saved" );
			} );
		}
	} )

	let view = new SettingsViewClass( {model: model, el: '.dash-adder-settings'} )

} )( jQuery );