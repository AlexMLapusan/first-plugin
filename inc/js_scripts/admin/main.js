( function ( $ ) {

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
		handleChange: function ( elem ) {
			console.log("Triggered");
			this.model.set( 'plugin_state', $( "input[name='dash-adder-state']:checked" ).val() );
			this.model.set( 'special_word', $( "#special-word" ).val() );
		},
		saveSettings: function () {

			$.ajax( {
				method: 'GET',
				url: dash_adder.rest_url + '?state=' + this.model.get( 'plugin_state' ) + '&special_word=' + this.model.get( 'special_word' ),
			} ).success(function (  ){
				alert("Settings saved");
			});
		}
	} )

	let view = new SettingsViewClass( {model: model, el: '.dash-adder-settings'} )

} )( jQuery );