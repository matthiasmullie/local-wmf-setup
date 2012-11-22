#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# ask for gerrit username to determine gerrit path
read -p "gerrit.wikimedia.org username? (empty for anonymous) " username
case $username in
  "" ) path="https://gerrit.wikimedia.org/r";;
  *  ) path="ssh://$username@gerrit.wikimedia.org:29418";;
esac

# create config
source $DIR/db.sh
source $DIR/cache.sh
source $DIR/environment.sh

# ask for admin username
read -p "wiki admin username? " ADMINUSER
read -p "wiki admin password? " ADMINPASS

# create file to save cluster to
echo "Creating /etc/wikimedia-realm (without, only production can be emulated)"
touch /etc/wikimedia-realm && chmod 777 /etc/wikimedia-realm

# setup wmf-config
echo "Cloning wmf-config..."
git clone "$path/operations/mediawiki-config" $DIR/../mediawiki

# setup mediawiki-core
echo "Cloning mediawiki core..."
git clone "$path/mediawiki/core" $DIR/../mediawiki/mediawiki

# setup mediawiki extensions
echo "Cloning mediawiki extensions..."
git clone --recursive "$path/mediawiki/extensions" $DIR/../mediawiki/mediawiki/extensions/extensions
find mediawiki/mediawiki/extensions/extensions -maxdepth 1 -exec mv {} mediawiki/mediawiki/extensions \;
rm -r mediawiki/mediawiki/extensions/extensions

# install db
php $DIR/../mediawiki/mediawiki/maintenance/install.php test $ADMINUSER --pass=$ADMINPASS --dbuser=$DBUSER --dbpass=$DBPASS --dbname=$DBNAME --dbserver=$DBHOST --dbtype=$DBTYPE --confpath=$DIR/../mediawiki/mediawiki
rm $DIR/../mediawiki/mediawiki/LocalSettings.php

# create missing files (see Stub.php)
ln -s $DIR/../hacks/LocalSettings.php $DIR/../mediawiki/mediawiki/LocalSettings.php
ln -s $DIR/../hacks/Stub.php $DIR/../mediawiki/wmf-config/PrivateSettings.php
ln -s $DIR/../hacks/Stub.php $DIR/../mediawiki/wmf-config/checkers.php
ln -s $DIR/../hacks/Stub.php $DIR/../mediawiki/wmf-config/ExtensionMessages-local.php
ln -s $DIR/../hacks/Stub.php $DIR/../mediawiki/wmf-config/mwblocker.log

# update setup
$DIR/update.sh
