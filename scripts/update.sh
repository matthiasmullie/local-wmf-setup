#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

echo "Running update..."

# checkout latest code
cd $DIR/../mediawiki && git pull --rebase origin master
cd $DIR/../mediawiki/mediawiki && git pull --rebase origin master
cd $DIR/../mediawiki/mediawiki/extensions && git pull --rebase origin master && git submodule update

# run update.php
php $DIR/../mediawiki/mediawiki/maintenance/update.php
