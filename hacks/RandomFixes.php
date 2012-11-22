<?php

// flaggedrevs deprecated these vars
if ( isset( $wgFlaggedRevTags ) ) {
	$wgFlaggedRevsTags = $wgFlaggedRevTags;
	unset( $wgFlaggedRevTags );
}
if ( isset( $wgFlagRestrictions ) ) {
	$wgFlaggedRevsTagsRestrictions = $wgFlagRestrictions;
	unset( $wgFlagRestrictions );
}

// mock apache-only method when not available
if ( !function_exists( 'apache_request_headers' ) ) {
	function apache_request_headers() {
		return array();
	}
}

// mock ApiTestUser if it does not exist
$autoloader = function() {
	if ( !class_exists( 'ApiTestUser' ) && class_exists( 'TestUser' ) ) {
		class ApiTestUser extends TestUser {}
	}
};
spl_autoload_register( $autoloader );
