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
	'wgStyleSheetPath' => isset( $wgStyleSheetPath ) ? $wgStyleSheetPath : '',
	'wgResourceBasePath' => $wgResourceBasePath,
	'wgStylePath' => $wgStylePath,
	'wgScriptPath' => '',
	'wgScript' => $wgScript,
	'wgScriptExtension' => $wgScriptExtension,
	'wgServer' => $wgServer,
	'wgSecureLogin' => $wgSecureLogin,
	'wgUseSquid' => $wgUseSquid,
//	'wgArticlePath' => $wgArticlePath, // .htaccess should have enabled .phtml parsing, so this is not necessary
	'wgEmergencyContact' => $wgEmergencyContact,
	'wgPasswordSender' => $wgPasswordSender,
	'wgVisualEditorParsoidURL' => $wgVisualEditorParsoidURL,
	'wgVisualEditorParsoidPrefix' => $wgVisualEditorParsoidPrefix,

	// logging-wmflabs.php
	'wgDebugLogFile' => $wgDebugLogFile,
	'wgFileBackends' => $wgFileBackends,
	'wgForeignFileRepos' => $wgForeignFileRepos,
	'wgLocalFileRepo' => $wgLocalFileRepo,

	// cluster servers won't be accessible anyway, and we will/might overwrite these ourselves
	'wgDBservers' => $wgDBservers,
	'wgExternalServers' => $wgExternalServers,

	// is not currently being messed up, but you never know...
	'wgMessageCacheType' => $wgMessageCacheType,

	// jobqueue-*.php
	'wgJobTypeConf' => $wgJobTypeConf, // I have no redis
	'wgJobQueueAggregator' => $wgJobQueueAggregator, // I have no redis
);

// CommonSettings.php will set it's own include_path
$includePath = get_include_path();

// init some vars to allow CommonSettings.php to be included
$wmfSwiftConfig['authUrl'] = null;
$wmfSwiftConfig['user'] = null;
$wmfSwiftConfig['key'] = null;
$wmfSwiftConfig['tempUrlKey'] = null;
$wmfSwiftEqiadConfig = $wmfSwiftConfig;
$wmgCaptchaSecret = null;
$wmgMFRemotePostFeedbackUsername = null;
$wmgMFRemotePostFeedbackPassword = null;
$_SERVER['HTTPS'] = '';
$_SERVER['HTTP_X_FORWARDED_FOR'] = '';
$_REQUEST['wpSave'] = '';

// filebackend.php
$wmfCephRgwConfig['authUrl'] = null;
$wmfCephRgwConfig['user'] = null;
$wmfCephRgwConfig['key'] = null;
$wmfCephRgwConfig['tempUrlKey'] = null;
$wmfCephRgwConfig['S3AccessKey'] = null;
$wmfCephRgwConfig['S3SecretKey'] = null;
$urlprotocol = '';

// I have no redis
$wmgRedisPassword = '';

require_once __DIR__.'/../mediawiki/wmf-config/CommonSettings.php';

// undo harm done in CommmonSettings.php by reinstating default settings
extract( $defaults );

// reset existing include path
set_include_path( get_include_path() . PATH_SEPARATOR . $includePath );
