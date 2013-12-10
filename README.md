# WMF cluster emulation

## What?
Wikimedia foundation runs [quite a few websites](https://wikimediafoundation.org/wiki/Our_projects) on the same [software](http://www.mediawiki.org).
For this, it has a rather complex configuration. Emulating the exact configuration of a specific website on your local machine is quite difficult.

This is a stab at using the WMF config locally, by hacking around some stuff the cluster setup assumes to be there (but may not be in a local setup).

## How?
I'll assume that your local webserver is properly configured, e.g. mediawiki.dev points to ~/mediawiki and you have an empty database configured.

* Clone this repository into ~/mediawiki
* Open shell and run $ php ~/mediawiki/scripts/install.sh
* You'll be prompted for details:
    * **gerrit.wikimedia.org username?** Leave empty if you have no account, this will result in read-only checkouts
    * **db type?** Either mysql or postgres
    * **db host?** Your database host (probably localhost)
    * **db name?** The name of the (empty) database
    * **db username?** Your database username
    * **db password?** Your database password
    * **shard db details**: Some extensions (can) have their data live on a seperate shard (or just use same core db)
    * **cache type?** The type of cache you'd like to use (if any); this will be also be used by $wgMessageCacheType, $wgParserCacheType, $wgSessionCacheType, $wgLanguageConverterCacheType
        * Available cache types: CACHE_NONE, CACHE_DB, CACHE_DBA, CACHE_ANYTHING, CACHE_ACCEL, CACHE_MEMCACHED, 'apc', 'xcache', 'wincache', 'memcached-php', 'memcached-pecl', 'hash'
        * In case you selected memcached, you'll be asked for you **cache server?** (in host:port format)
    * **cluster to emulate?** Whether you want to emulate labs or production
    * **parsoid url?** URL to reach your [Parsoid setup](https://www.mediawiki.org/wiki/Parsoid#Parsoid_setup) (or nothing if you don't have it, in which case VisualEditor won't work)
    * **parsoid prefix?** Your setup's parsoid prefix
    * **wiki to emulate?** Which wiki to emulate (e.g. enwiki)
    * **wiki admin username?** The admin username for your wiki install (password will be empty)
* Script should automatically clone wmf-config, mediawiki core & mediawiki extensions
* Afterwards, you can always run:
    * $ php ~/mediawiki/scripts/db.sh : change db credentials
    * $ php ~/mediawiki/scripts/cache.sh : change cache config
    * $ php ~/mediawiki/scripts/environment.sh : switch wiki environment
    * $ php ~/mediawiki/scripts/parsoid.sh : change parsoid setup
    * $ php ~/mediawiki/scripts/update.sh : update codebases (hint: cronjob)

After running the setup (and if you didn't encounter any error), you should be able to surf to whatever vhost you configured (e.g. mediawiki.dev) and find a local copy of the

## Differences?

### CentralAuth
CentralAuth can not be accessed from your local machine, so will be unloaded.

### Captcha
FancyCaptcha requires images in $wgCaptchaDirectory, so this setup will use SimpleCaptcha.
