<?php

// assume DB is up-to-date
$wgOldChangeTagsIndex = false;

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


// we don't want the workaround for bug 54847 here
$bug54847 = function ( $user ) {
	global $wgMemc;
	$wgMemc->set( 'centralauth:reset-pass:' . md5( $user->getName() ), 'no' );
	return true;
};
array_unshift( $wgHooks['UserLoadAfterLoadFromSession'], $bug54847 );
array_unshift( $wgHooks['UserLoadFromSession'], $bug54847 );
array_unshift( $wgHooks['AbortLogin'], $bug54847 );
if ( isset( $wgHooks['AbortChangePassword'] ) ) {
	array_unshift( $wgHooks['AbortChangePassword'], $bug54847 );
}
