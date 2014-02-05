<?php

foreach ( $wgHooks as $i => $hook ) {
	foreach ( $hook as $j => $callback ) {
		if ( !is_string( $callback ) ) {
			break;
		}

		if ( strpos( $callback, 'MWOAuthUIHooks' ) !== false ) {
			unset( $wgHooks[$i][$j] );
		}
	}
}
