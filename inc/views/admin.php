<h2>Dash adder settings</h2>
<div class="dash-adder-settings">

</div>

<script id="custom-template" type="text/html">

	<div>
		<input data-model_attr_name = "plugin_state" class="state" id="dash-adder-on" <%= option === 'on'? 'checked' : '' %> type="radio" name="dash-adder-state" value="on">
		<label for="dash-adder-on">ON</label>
		<input data-model_attr_name = "plugin_state" class="state" id="dash-adder-off" <%= option === 'on'? '' : 'checked' %> type="radio" name="dash-adder-state" value="off">
		<label for="dash-adder-off">OFF</label><br/>
	</div>
	<div>
		<label for="special-word">Special word: </label>
		<input data-model_attr_name = "special_word" id="special-word"  type="text" name="special-word" value=<%= special_word %> >
	</div>
	<div>
		<button id="save-settings">Save</button>
	</div>
</script>
