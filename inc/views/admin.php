<h2>Dash adder settings</h2>
<div class="wrap dash-adder-settings">

</div>

<script id="custom-template" type="text/html">

	<input model_attr_name = "state" class="state" id="dash-adder-on" <%= option === 'on'? 'checked' : '' %> type="radio" name="dash-adder-state" value="on">
	<label for="dash-adder-on">ON</label>
	<input class="state" id="dash-adder-off" <%= option === 'on'? '' : 'checked' %> type="radio" name="dash-adder-state" value="off">
	<label for="dash-adder-off">OFF</label><br/>
	<label for="dash-adder-before">Before text</label>
	<input id="in-front-addtition"  type="text" name="dash-adder-before" placeholder="Enter text here">
<!--	<button class="save-state">Save</button>-->
</script>

<!--//cum sa adaugi scripturi in pagina (enqueue script)-->
<!--//cum sa localizezi informatii din php in js (localize script)-->
<!--//moldel la change trebuie sa salveze optiunea-->
<!--//register route in WP-->
<!--//afisare cu template + backbone view-->
<!--//var 1- informatia din model o primim din php de la inceput cu localize (II)-->
<!--//var 2- la page load modelul isi face fetch si aduce informatia din ajax-->
