#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# ask for cluster/wiki to emulate
read -p "cluster to emulate? (labs, production) " ENVCLUSTER
read -p "wiki to emulate? (enwiki, dewiki, enwikivoyage, ...) " ENVWIKI
if [[ ! $ENVWIKI ]]; then
  ENVWIKI="enwiki"
fi
if [[ ! $ENVCLUSTER ]]; then
  ENVCLUSTER="production"
fi

# write config file
sed -e "s/\[ENVWIKI\]/$ENVWIKI/g" -e "s/\[ENVCLUSTER\]/$ENVCLUSTER/g" $DIR/../config/environment.sample > $DIR/../config/environment.php
