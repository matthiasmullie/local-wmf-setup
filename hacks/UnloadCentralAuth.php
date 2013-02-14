<?php

/**
 * wmf-config will setup CentralAuth & GlobalUsage, which we can't run
 * locally; this will disable them completely
 */
unset(
	$wgCentralAuthDatabase,
	$wgCentralAuthAutoNew,
	$wgCentralAuthAutoMigrate,
	$wgCentralAuthStrict,
	$wgCentralAuthDryRun,
	$wgCentralAuthCookies,
	$wgCentralAuthCookieDomain,
	$wgCentralAuthCookiePrefix,
	$wgCentralAuthAutoLoginWikis,
	$wgCentralAuthLoginIcon,
	$wgCentralAuthCreateOnView,
	$wgCentralAuthUDPAddress,
	$wgCentralAuthNew2UDPPrefix,
	$wgCentralAuthLockedCanEdit,
	$wgCentralAuthWikisPerSuppressJob,
	$wgExtensionMessagesFiles['SpecialCentralAuth'],
	$wgExtensionMessagesFiles['SpecialCentralAuthAliases'],
	$wgJobClasses['crosswikiSuppressUser'],
	$wgResourceModules['ext.centralauth'],
	$wgResourceModules['ext.centralauth.noflash'],
	$wgHooks['CentralAuthWikiList'],
	$wgGlobalBlockingDatabase,
	$wgSpecialPages['CentralAuth'],
	$wgSpecialPages['AutoLogin'],
	$wgSpecialPages['MergeAccount'],
	$wgSpecialPages['GlobalGroupMembership'],
	$wgSpecialPages['GlobalGroupPermissions'],
	$wgSpecialPages['WikiSets'],
	$wgSpecialPages['GlobalUsers'],
	$wgSpecialPageGroups['CentralAuth'],
	$wgSpecialPageGroups['MergeAccount'],
	$wgSpecialPageGroups['GlobalGroupMembership'],
	$wgSpecialPageGroups['GlobalGroupPermissions'],
	$wgSpecialPageGroups['WikiSets'],
	$wgSpecialPageGroups['GlobalUsers']
);
$wgApplyGlobalBlocks = false;
$wgCentralAuthCookies = false;
foreach ( $wgHooks as $i => $hook ) {
	foreach ( $hook as $j => $callback ) {
		if ( !is_string( $callback ) ) {
			break;
		}

		if (
			// disable CentralAuth
			strpos( $callback, 'CentralAuthHooks' ) !== false || strpos( $callback, 'CentralAuthAntiSpoofHooks' ) !== false ||
			// disable GlobalUsage
			strpos( $callback, 'GlobalUsageHooks' ) !== false
		) {
			unset( $wgHooks[$i][$j] );
		}
	}
}
