( function ( $ ) {

	//TODO: Trimitem setarile pentru plug-in ca un array de obiecte 'nume_setare' => 'valoare_relevanta'
	//TODO: work with fetch
	//TODO: check the post bug

	let model = new Backbone.Model( {plugin_state: dash_adder_settings.state} );

	let SettingsViewClass = Backbone.View.extend( {
		initialize: function () {
			this.render();
			this.model.on( 'change', function () {
				console.log( "this.get( 'plugin_state' )" );
//				$.ajax( {
//					method: 'GET',
//					url: dash_adder_settings.rest_url + "?state=" + this.get( 'plugin_state' ),
//				} )
			} );
//			console.log(this.model.plugin_state);

//			this.model.attributes.plugin_state === 'on' ? $("#dash-adder-on").prop("checked", true) : $("#dash-adder-off").prop("checked", true) ;
		},
		render: function () {
			const _html = $( "#custom-template" ).html();
			this.$el.html( _.template( _html )( {'option': this.model.get( 'plugin_state' )} ) );

		},
		events: {
			'click .state': 'handleClick',
			'change #in-front-addtition' : 'handleClick',
		},
		handleClick: function ( elem ) {
			console.log("Click detected");
			this.model.set( 'plugin_state', $( "input[name='dash-adder-state']:checked" ).val() );
		}
	} )

	let view = new SettingsViewClass( {model: model, el: '.dash-adder-settings'} )

} )( jQuery );