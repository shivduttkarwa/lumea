( function () {
	var i18n = ( window.lumeaData && window.lumeaData.i18n ) ? window.lumeaData.i18n : {};

	
	document.querySelectorAll( '[data-lumea-pw-toggle]' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			var wrap  = btn.closest( '.lumea-pw-wrap' );
			var input = wrap ? wrap.querySelector( '.lumea-pw-input' ) : null;
			if ( ! input ) return;

			var isText = input.type === 'text';
			input.type = isText ? 'password' : 'text';

			var eyeOn  = btn.querySelector( '.lumea-pw-eye' );
			var eyeOff = btn.querySelector( '.lumea-pw-eye-off' );
			if ( eyeOn )  eyeOn.hidden  = ! isText;
			if ( eyeOff ) eyeOff.hidden =   isText;

			btn.setAttribute( 'aria-label', isText
				? ( i18n.showPassword || '' )
				: ( i18n.hidePassword || '' )
			);
		} );
	} );

	
	var newPwInput   = document.getElementById( 'password_1' );
	var strengthWrap = document.getElementById( 'lumea-pw-strength' );

	if ( newPwInput && strengthWrap ) {
		var bar   = strengthWrap.querySelector( '.lumea-pw-strength-bar' );
		var label = strengthWrap.querySelector( '.lumea-pw-strength-label' );

		var levels = [
			{ cls: '',       text: '' },
			{ cls: 'weak',   text: i18n.pwWeak   || '' },
			{ cls: 'fair',   text: i18n.pwFair   || '' },
			{ cls: 'good',   text: i18n.pwGood   || '' },
			{ cls: 'strong', text: i18n.pwStrong || '' },
		];

		function scorePassword( pw ) {
			if ( ! pw ) return 0;
			var score = 0;
			if ( pw.length >= 8  ) score++;
			if ( pw.length >= 12 ) score++;
			if ( /[A-Z]/.test( pw ) && /[a-z]/.test( pw ) ) score++;
			if ( /[0-9]/.test( pw ) ) score++;
			if ( /[^A-Za-z0-9]/.test( pw ) ) score++;
			return Math.min( 4, score );
		}

		newPwInput.addEventListener( 'input', function () {
			var pw = newPwInput.value;
			if ( ! pw ) {
				strengthWrap.hidden = true;
				bar.className = 'lumea-pw-strength-bar';
				label.textContent = '';
				return;
			}
			var lvl = levels[ scorePassword( pw ) ] || levels[ 0 ];
			strengthWrap.hidden = false;
			bar.className  = 'lumea-pw-strength-bar' + ( lvl.cls ? ' is-' + lvl.cls : '' );
			label.textContent = lvl.text;
		} );
	}
} )();
