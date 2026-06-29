/**
 * Customizer Controls JS.
 *
 * Handles range slider ↔ number input sync. The number input carries the
 * WP Customize setting link (data-customize-setting-link), so routing all
 * changes through it triggers postMessage live preview automatically.
 *
 * Conditional control visibility bindings are injected via wp_add_inline_script()
 * from Axiom\Customizer\Manager::enqueue_controls().
 */
( function () {
	'use strict';

	function initRangeControls() {
		document.querySelectorAll( '.axiom-range-wrap' ).forEach( function ( wrap ) {
			var slider = wrap.querySelector( '.axiom-range-slider' );
			var number = wrap.querySelector( '.axiom-range-number' );
			if ( ! slider || ! number ) {
				return;
			}

			// Slider drag → mirror value to number, then fire input on number so
			// WP Customize's own binding picks it up and sends a postMessage to
			// the preview iframe — giving true real-time preview.
			slider.addEventListener( 'input', function () {
				number.value = slider.value;
				number.dispatchEvent( new Event( 'input', { bubbles: true } ) );
			} );

			// Number typed → keep slider thumb in sync.
			// WP Customize binds directly to number (via data-customize-setting-link),
			// so no extra dispatch needed here.
			number.addEventListener( 'input', function () {
				slider.value = number.value;
			} );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initRangeControls );
	} else {
		initRangeControls();
	}
} )();
