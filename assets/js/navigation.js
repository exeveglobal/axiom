/**
 * Axiom Navigation — vanilla JS, no jQuery, no build step required.
 * Handles: mobile menu toggle, sticky header, auto-hide on scroll.
 */

( function () {
	'use strict';

	const header   = document.getElementById( 'axiom-header' );
	const toggle   = header?.querySelector( '.axiom-nav-toggle' );
	const mobileNav = document.getElementById( 'axiom-mobile-nav' );

	// ── Mobile menu toggle ──────────────────────────────────────────────────
	if ( toggle && mobileNav ) {
		const breakpoint = parseInt( toggle.dataset.breakpoint || '768', 10 );

		function openMenu() {
			toggle.setAttribute( 'aria-expanded', 'true' );
			toggle.setAttribute( 'aria-label', toggle.dataset.labelClose || 'Close menu' );
			mobileNav.setAttribute( 'aria-hidden', 'false' );
			mobileNav.removeAttribute( 'inert' );
		}

		function closeMenu() {
			toggle.setAttribute( 'aria-expanded', 'false' );
			toggle.setAttribute( 'aria-label', toggle.dataset.labelOpen || 'Open menu' );
			mobileNav.setAttribute( 'aria-hidden', 'true' );
			mobileNav.setAttribute( 'inert', '' );
		}

		toggle.addEventListener( 'click', function () {
			const expanded = toggle.getAttribute( 'aria-expanded' ) === 'true';
			expanded ? closeMenu() : openMenu();
		} );

		// Close on Escape
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' ) closeMenu();
		} );

		// Close if viewport grows past breakpoint
		const mq = window.matchMedia( `(min-width: ${ breakpoint }px)` );
		mq.addEventListener( 'change', function ( e ) {
			if ( e.matches ) closeMenu();
		} );
	}

	// ── Sticky + auto-hide ──────────────────────────────────────────────────
	if ( header?.classList.contains( 'is-sticky' ) ) {
		const autohide   = header.classList.contains( 'is-autohide' );
		let lastScrollY  = window.scrollY;
		let ticking      = false;

		function onScroll() {
			const currentY = window.scrollY;

			if ( autohide ) {
				if ( currentY > lastScrollY && currentY > 80 ) {
					header.classList.add( 'is-hidden' );
				} else {
					header.classList.remove( 'is-hidden' );
				}
			}

			header.classList.toggle( 'is-scrolled', currentY > 10 );
			lastScrollY = currentY;
			ticking = false;
		}

		window.addEventListener( 'scroll', function () {
			if ( ! ticking ) {
				window.requestAnimationFrame( onScroll );
				ticking = true;
			}
		}, { passive: true } );
	}

} )();
