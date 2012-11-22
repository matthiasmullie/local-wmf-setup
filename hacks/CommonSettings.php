<?php

/*
 * This will load CommonSettings.php, which will prep whatever requested cluster/wiki
 * setup configuration. However, some cluster config needs to be "fixed" for local
 * setup (e.g. no access to CentralAuth)
 */

// cluster will be read from /etc/wikimedia-realm
if ( file_exists( '/etc/wikimedia-realm' ) && is_writable( '/etc/wikimedia-realm' ) ) {
	file_put_contents( '/etc/wikimedia-realm', $cluster );
} elseif ( $cluster != 'production' ) {
	exit( 'Unless /etc/wikimedia-realm exists and is writable, only production cluster config can be loaded' );
}

// save DefaultSettings.php data to be reset later, after wmf-config has messed it up,
// assuming a cluster setup (mostly related to external resources, e.g. cache)
$defaults = array(
	// db.php
	'wgLBFactoryConf' => $wgLBFactoryConf,
	'wgDefaultExternalStore' => $wgDefaultExternalStore,

	// mc.php
	'wgObjectCaches' => $wgObjectCaches,
	'wgMainCacheType' => $wgMainCacheType,
	'wgMemCachedServers' => $wgMemCachedServers,

	// InitialiseSettings.php
	'wgLanguageConverterCacheType' => $wgLanguageConverterCacheType,

	// CommonSettings.php
	'wgSessionCacheType' => $wgSessionCacheType,
	'wgParserCacheType' => $wgParserCacheType,
	'wgCacheDirectory' => $wgCacheDirectory,
	'wgLoadScript' => $wgLoadScript,
	'wgLocalisationCacheConf' => $wgLocalisationCacheConf,
	'wgExtensionAssetsPath' => $wgExtensionAssetsPath,
	'wgStyleSheetPath' => $wgStyleSheetPath,
	'wgResourceBasePath' => $wgResourceBasePath,
	'wgStylePath' => $wgStylePath,
	'wgScriptPath' => '',
	'wgScript' => $wgScript,
	'wgScriptExtension' => $wgScriptExtension,
	'wgServer' => $wgServer,
	'wgUseSquid' => $wgUseSquid,
//	'wgArticlePath' => $wgArticlePath, // .htaccess should have enabled .phtml parsing, so this is not necessary
	'wgEmergencyContact' => $wgEmergencyContact,
	'wgPasswordSender' => $wgPasswordSender,

	// logging-wmflabs.php
	'wgDebugLogFile' => $wgDebugLogFile,
	'wgFileBackends' => $wgFileBackends,
	'wgForeignFileRepos' => $wgForeignFileRepos,

	// we just defined this ourselves (Config.php) and don't want it to be overwritten
	'wgDBservers' => $wgDBservers,

	// is not currently being messed up, but you never know...
	'wgMessageCacheType' => $wgMessageCacheType,
);

// init some vars to allow CommonSettings.php to be included
$wmfSwiftConfig['authUrl'] = null;
$wmfSwiftConfig['user'] = null;
$wmfSwiftConfig['key'] = null;
$wmfSwiftConfig['tempUrlKey'] = null;
$wmgCaptchaSecret = null;
$wmgMFRemotePostFeedbackUsername = null;
$wmgMFRemotePostFeedbackPassword = null;
$_SERVER['HTTPS'] = '';
$_SERVER['HTTP_X_FORWARDED_FOR'] = '';
$_REQUEST['wpSave'] = '';

require_once __DIR__.'/../mediawiki/wmf-config/CommonSettings.php';

// undo harm done in CommmonSettings.php by reinstating default settings
extract( $defaults );
