<h2>Dash adder settings</h2>
<div class="post_modifier-settings">

</div>

<script id="custom-template" type="text/html">

	<div>
		<input data-model_attr_name = "plugin_state" class="state" id="post-modifier-on" <%= option === 'on'? 'checked' : '' %> type="radio" name="post_modifier-state" value="on">
		<label for="post_modifier-on">ON</label>
		<input data-model_attr_name = "plugin_state" class="state" id="post-modifier-off" <%= option === 'on'? '' : 'checked' %> type="radio" name="post_modifier-state" value="off">
		<label for="post_modifier-off">OFF</label><br/>
	</div>
	<div>
		<label for="special-word">Special word: </label>
		<input data-model_attr_name = "special_word" id="special-word"  type="text" name="special-word" value=<%= special_word %> >
	</div>
	<div>
		<label for="color-picker">Header Color: </label>
		<input data-model_attr_name = "header_color" id="header_color"  type="text" name="color-picker" >
	</div>
	<div>
		<button id="save-settings">Save</button>
	</div>
</script>
