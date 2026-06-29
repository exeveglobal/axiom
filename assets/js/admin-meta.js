/**
 * Admin Metabox — image picker using the WP Media Library.
 */
wp.domReady( function () {
	document.querySelectorAll( '[data-target]' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			const targetId = btn.dataset.target;
			const input    = document.getElementById( targetId );
			if ( ! input ) return;

			const frame = wp.media( {
				title:    'Select Image',
				button:   { text: 'Use this image' },
				multiple: false,
			} );

			frame.on( 'select', function () {
				const attachment = frame.state().get( 'selection' ).first().toJSON();
				input.value = attachment.id;
				const preview = btn.nextElementSibling;
				if ( preview && preview.tagName === 'IMG' ) {
					preview.src = attachment.sizes?.thumbnail?.url || attachment.url;
				} else {
					const img = document.createElement( 'img' );
					img.src   = attachment.sizes?.thumbnail?.url || attachment.url;
					img.style.cssText = 'max-width:100%;margin-top:4px;display:block;';
					btn.insertAdjacentElement( 'afterend', img );
				}
			} );

			frame.open();
		} );
	} );
} );
