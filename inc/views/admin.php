<h2>Post Settings</h2>
<div class="post_modifier-settings">

</div>

<script id="custom-template" type="text/html">

	<div>
		<input data-model_attr_name="plugin_state" class="state" id="post-modifier-on" <%= option === 'on'? 'checked' : '' %> type="radio" name="post_modifier-state" value="on">
		<label for="post_modifier-on">ON</label>
		<input data-model_attr_name="plugin_state" class="state" id="post-modifier-off" <%= option === 'on'? '' : 'checked' %> type="radio" name="post_modifier-state" value="off">
		<label for="post_modifier-off">OFF</label><br/>
	</div>
	<div>
		<label for="special-word">Special word: </label>
		<input data-model_attr_name="special_word" id="special-word" type="text" name="special-word" value="<%= special_word %>" >
	</div>
	<div>
		<label for="header-color-picker">Header color: </label>
		<input data-model_attr_name="header_color" class="color-picker" id="header_color" type="text" name="header-color-picker">
	</div>
	<div>
		<label for="content-color-picker">Post text color: </label>
		<input data-model_attr_name="content_color" class="color-picker" id="content_color" type="text" name="content-color-picker">
	</div>
	<div>
		<label for="custom_date_format">Date format: </label>
		<input data-model_attr_name="custom_date_format" id="custom_date_format" type="text" name="custom_date_format" value="<%= date_format %>">
	</div>

	<div>
		<button id="save-settings">Save</button>
	</div>
</script>
