#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# ask for cache details
CACHESERVER=""
echo "available cache types: CACHE_NONE, CACHE_DB, CACHE_DBA, CACHE_ANYTHING, CACHE_ACCEL, CACHE_MEMCACHED, 'apc', 'xcache', 'wincache', 'memcached-php', 'memcached-pecl', 'hash'"
read -p "cache type? " CACHETYPE
case $CACHETYPE in
  "memcached-php" | "'memcached-php'"     ) CACHETYPE="'memcached-php'"
                                            read -p "cache server? (host:port) " CACHESERVER;;
  "memcached-pecl" | "'memcached-pecl'"   ) CACHETYPE="'memcached-pecl'"
                                            read -p "cache server? (host:port) " CACHESERVER;;
  "CACHE_DB" | "'CACHE_DB'"               ) CACHETYPE="CACHE_DB";;
  "CACHE_DBA" | "'CACHE_DBA'"             ) CACHETYPE="CACHE_DBA";;
  "CACHE_ANYTHING" | "'CACHE_ANYTHING'"   ) CACHETYPE="CACHE_ANYTHING";;
  "CACHE_ACCEL" | "'CACHE_ACCEL'"         ) CACHETYPE="CACHE_ACCEL";;
  "CACHE_MEMCACHED" | "'CACHE_MEMCACHED'" ) CACHETYPE="CACHE_MEMCACHED";;
  "apc" | "'apc'"                         ) CACHETYPE="'apc'";;
  "xcache" | "'xcache'"                   ) CACHETYPE="'xcache'";;
  "wincache" | "'wincache'"               ) CACHETYPE="'wincache'";;
  "hash" | "'hash'"                       ) CACHETYPE="'hash'";;
  "CACHE_NONE" | "'CACHE_NONE'" | *       ) CACHETYPE="CACHE_NONE";;
esac

# write config file
sed -e "s/\[CACHETYPE\]/$CACHETYPE/g" -e "s/\[CACHESERVER\]/$CACHESERVER/g" $DIR/../config/cache.sample > $DIR/../config/cache.php
