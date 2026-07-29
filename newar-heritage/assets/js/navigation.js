/**
 * Newar Heritage — Navigation
 *
 * Handles mobile navigation toggle and skip link focus.
 */

( function() {
    'use strict';

    var body = document.body;

    var onResize = function() {
        if ( body.classList.contains( 'menu-open' ) && window.innerWidth > 767 ) {
            body.classList.remove( 'menu-open' );
        }
    };

    if ( 'undefined' !== typeof window ) {
        window.addEventListener( 'resize', onResize );
    }
} )();
