/**
 * Axiom Navigation — vanilla JS, no jQuery, no build step.
 * Mobile nav: left-side drawer with backdrop.
 * Sticky header: scroll-driven show / hide.
 */

( function () {
	'use strict';

	const header    = document.getElementById( 'axiom-header' );
	const toggle    = header?.querySelector( '.axiom-nav-toggle' );
	const mobileNav = document.getElementById( 'axiom-mobile-nav' );

	// ── Mobile drawer ───────────────────────────────────────────────────────
	if ( toggle && mobileNav ) {

		// Move the drawer to <body> so it escapes the header's stacking context.
		// The header has z-index:200 and creates its own stacking context, which
		// would place the drawer beneath a body-level backdrop at z-index:299.
		document.body.appendChild( mobileNav );

		// Backdrop — sits behind the drawer, click to close
		const backdrop = document.createElement( 'div' );
		backdrop.className = 'axiom-nav-backdrop';
		backdrop.setAttribute( 'aria-hidden', 'true' );
		document.body.appendChild( backdrop );

		// Close button — injected at the top of the drawer
		const closeBtn = document.createElement( 'button' );
		closeBtn.className = 'axiom-nav-close';
		closeBtn.setAttribute( 'aria-label', 'Close menu' );
		closeBtn.innerHTML = '&#x2715;'; // ✕
		mobileNav.prepend( closeBtn );

		function openMenu() {
			toggle.setAttribute( 'aria-expanded', 'true' );
			mobileNav.setAttribute( 'aria-hidden', 'false' );
			mobileNav.removeAttribute( 'inert' );
			mobileNav.classList.add( 'is-open' );
			backdrop.classList.add( 'is-visible' );
			document.body.style.overflow = 'hidden';
			// Focus the close button for keyboard users
			closeBtn.focus();
		}

		function closeMenu() {
			toggle.setAttribute( 'aria-expanded', 'false' );
			mobileNav.setAttribute( 'aria-hidden', 'true' );
			mobileNav.setAttribute( 'inert', '' );
			mobileNav.classList.remove( 'is-open' );
			backdrop.classList.remove( 'is-visible' );
			document.body.style.overflow = '';
			toggle.focus();
		}

		toggle.addEventListener( 'click', function () {
			toggle.getAttribute( 'aria-expanded' ) === 'true' ? closeMenu() : openMenu();
		} );

		closeBtn.addEventListener( 'click', closeMenu );
		backdrop.addEventListener( 'click', closeMenu );

		// Escape key
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && toggle.getAttribute( 'aria-expanded' ) === 'true' ) {
				closeMenu();
			}
		} );

		// Auto-close if viewport widens past mobile breakpoint
		window.matchMedia( '(min-width: 768px)' ).addEventListener( 'change', function ( e ) {
			if ( e.matches ) closeMenu();
		} );
	}

	// ── Sticky + auto-hide ──────────────────────────────────────────────────
	if ( header?.classList.contains( 'is-sticky' ) ) {
		const autohide  = header.classList.contains( 'is-autohide' );
		let lastScrollY = window.scrollY;
		let ticking     = false;

		function onScroll() {
			const y = window.scrollY;

			header.classList.toggle( 'is-scrolled', y > 10 );

			if ( autohide ) {
				if ( y > lastScrollY && y > 80 ) {
					header.classList.add( 'is-hidden' );
				} else {
					header.classList.remove( 'is-hidden' );
				}
			}

			lastScrollY = y;
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
