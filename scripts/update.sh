#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

echo "Running update..."

# checkout config master
cd $DIR/../mediawiki && git pull --rebase origin master

# checkout latest wmf* branch
cd $DIR/../mediawiki/mediawiki
ORIGIN=$(for BRANCH in `git branch -r | grep "origin/wmf/"`; do echo -e `git show --pretty=format:"%ci" $BRANCH | head -n 1`,$BRANCH; done | sort -r | head -n 1 | sed "s/^.*,//")
LOCAL=`echo $ORIGIN | sed "s/origin\///"`
git branch --track $LOCAL $ORIGIN
git checkout $LOCAL && git pull

# checkout extensions
cd $DIR/../mediawiki/mediawiki && git submodule update --init --recursive

# run update.php
php $DIR/../mediawiki/mediawiki/maintenance/update.php
