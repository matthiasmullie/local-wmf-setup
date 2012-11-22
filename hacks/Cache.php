<?php

// $wgMainCacheType = CACHE_NONE; // is set in config/cache.php

// if these are CACHE_ANYTHING, they'll result in the same cache as $wgMainCacheType
$wgMessageCacheType = CACHE_ANYTHING;
$wgParserCacheType = CACHE_ANYTHING;
$wgSessionCacheType = CACHE_ANYTHING;
$wgLanguageConverterCacheType = CACHE_ANYTHING;

// if igbinary is not installed, use default php serializer
if ( !Memcached::HAVE_IGBINARY) {
	$wgObjectCaches['memcached-pecl']['serializer'] = 'php';
}

// save session data in cache
if ( $wgSessionCacheType != CACHE_NONE ) {
	$wgSessionsInMemcached = true;
}
