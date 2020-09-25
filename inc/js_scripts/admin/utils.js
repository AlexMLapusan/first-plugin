/**
 * Returns the template function or rendered template content for a backbone template
 *
 * @param {string} templatePath path to the template (e.g. dir1/page-loader)
 * @param {object} [options] optional. If sent, it will return html content (the rendered template)
 */
function tpl( templatePath, options ) {
	const _html = jQuery( 'script#' + templatePath.replace( /\//g, '-' ) ).html() || '';

	if ( options ) {
		return _.template( _html )( options );
	}

	return _.template( _html );
}