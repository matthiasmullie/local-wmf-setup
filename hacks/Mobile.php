<?php

/*
 * This test-setup is built around the assumption that <device>.<uri>
 * (e.g. iphone.mediawiki.dev) should display the mobile view for the
 * given <device>, while <uri> should not.
 *
 * These devices are currently available:
 * html, capable, webkit, ie, android, iphone, iphone2, native_iphone,
 * palm_pre, kindle, kindle2, blackberry, blackberry-lt5, netfront, wap2,
 * psp, ps3, wii, operamini, operamobile, nokia, wml
 *
 * build mobile url template based on whatever we are requesting, e.g.:
 * * iphone.mediawiki.dev => m.%h0.%h1
 * * iphone.mediawiki.127.0.0.1.xip.io => m.%h0.%h1.%h2.%h3.%h4.%h5.%h6
 */
$wgMobileUrlTemplate = '';
if ( isset( $_SERVER['HTTP_HOST'] ) ) {
	$count = 0;
	$callback = function() {
		global $count;
		return '.%h'.$count++;
	};
	if ( getenv( 'MOBILE' ) || getenv( 'REDIRECT_MOBILE' ) ) {
		$wgMobileUrlTemplate = preg_replace_callback( '/\.[^\.]+/', $callback, $_SERVER['HTTP_HOST'] );
	} else {
		// if not in mobile view, set template as iphone view (quite useless though, might as well just set empty string)
		$wgMobileUrlTemplate = 'iphone'. preg_replace_callback( '/\.?[^\.]+/', $callback, $_SERVER['HTTP_HOST'] );
	}
}
