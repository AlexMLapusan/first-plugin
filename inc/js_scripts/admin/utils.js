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

function initSpectrum( options, callback ) {
	options.target.spectrum( {
		color: options.color,
		showButtons: false,
	} ).on( 'dragstop.spectrum', ( e, color ) => {
		jQuery( e.currentTarget ).spectrum( 'set', color.toHex() );
		callback( color.toHex() );

	} );
}

/**
 * Returns the date format transformed from the wordpress standard format to the moment() format
 * @param format
 * @returns {string}
 */
function getMomentFormat( format ) {
	let formatMap = {
		d: 'DD',
		D: 'ddd',
		j: 'D',
		l: 'dddd',
		N: 'E',
		S: function () {
			return '[' + this.format( 'Do' ).replace( /\d*/g, '' ) + ']';
		},
		w: 'd',
		z: function () {
			return this.format( 'DDD' ) - 1;
		},
		W: 'W',
		F: 'MMMM',
		m: 'MM',
		M: 'MMM',
		n: 'M',
		t: function () {
			return this.daysInMonth();
		},
		L: function () {
			return this.isLeapYear() ? 1 : 0;
		},
		o: 'GGGG',
		Y: 'YYYY',
		y: 'YY',
		a: 'a',
		A: 'A',
		B: function () {
			var thisUTC = this.clone().utc(),
				// Shamelessly stolen from http://javascript.about.com/library/blswatch.htm
				swatch = ( ( thisUTC.hours() + 1 ) % 24 ) + ( thisUTC.minutes() / 60 ) + ( thisUTC.seconds() / 3600 );
			return Math.floor( swatch * 1000 / 24 );
		},
		g: 'h',
		G: 'H',
		h: 'hh',
		H: 'HH',
		i: 'mm',
		s: 'ss',
		u: '[u]', // not sure if moment has this
		e: '[e]', // moment does not have this
		I: function () {
			return this.isDST() ? 1 : 0;
		},
		O: 'ZZ',
		P: 'Z',
		T: '[T]', // deprecated in moment
		Z: function () {
			return parseInt( this.format( 'ZZ' ), 10 ) * 36;
		},
		c: 'YYYY-MM-DD[T]HH:mm:ssZ',
		r: 'ddd, DD MMM YYYY HH:mm:ss ZZ',
		U: 'X',
	}

	let response = "";
	Array.from( format ).forEach( letter => {
		if ( formatMap[ letter ] !== undefined ) {
			letter =  formatMap[ letter ];
		}
		response += "" + letter;
	} );
	return response;
}