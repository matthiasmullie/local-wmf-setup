<?php

/**
 * wmf-config will setup Wikidata, which we can't run
 * locally; this will disable it completely
 */
$wmgUseWikibaseRepo = false;
$wmgUseWikibaseClient = false;
$wgWBSettings['repoDatabase'] = false;
$wgWBSettings['changesDatabase'] = null;
$wgWBSettings['localClientDatabases'] = null;

foreach ( $wgHooks as $i => $hook ) {
	foreach ( $hook as $j => $callback ) {
		if ( !is_string( $callback ) ) {
			break;
		}

		if ( strpos( $callback, '\Wikibase' ) !== false ) {
			unset( $wgHooks[$i][$j] );
		}
	}
}
