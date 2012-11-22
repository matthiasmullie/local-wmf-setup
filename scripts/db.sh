#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# ask for db credentials
read -p "db type? (mysql, postgres) " DBTYPE
read -p "db host? (empty for 127.0.0.1) " DBHOST
read -p "db name? " DBNAME
read -p "db username? " DBUSER
read -p "db password? " DBPASS
if [[ ! $DBTYPE ]]; then
  DBTYPE="mysql"
fi
if [[ ! $DBHOST ]]; then
  DBHOST="127.0.0.1"
fi

# write config file
sed -e "s/\[DBTYPE\]/$DBTYPE/g" -e "s/\[DBHOST\]/$DBHOST/g" -e "s/\[DBNAME\]/$DBNAME/g" -e "s/\[DBUSER\]/$DBUSER/g" -e "s/\[DBPASS\]/$DBPASS/g" $DIR/../config/db.sample > $DIR/../config/db.php
