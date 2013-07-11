<?php

/**
 * wmf-config will setup VisualEditor, which needs Parsoid
 * to run; this will disable it completely
 *
 * If you want to setup VisualEditor, find instructions on
 * http://www.mediawiki.org/wiki/Extension:VisualEditor to
 * setup Parsoid. Then ignore this file and correctly
 * configure $wgVisualEditorParsoidURL
 */
$wmgUseVisualEditor = false;

foreach ( $wgHooks as $i => $hook ) {
	foreach ( $hook as $j => $callback ) {
		if ( !is_string( $callback ) ) {
			break;
		}

		if ( strpos( $callback, 'VisualEditorHooks' ) !== false ) {
			unset( $wgHooks[$i][$j] );
		}
	}
}

foreach ( $wgResourceModules as $module => $data ) {
	if ( strpos( $module, 'ext.visualEditor' ) !== false ) {
		unset( $wgResourceModules[$module] );
	}
}
