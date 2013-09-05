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

# ask for shard details
echo "Some extensions' data can live on a separate shard (extension1)"
read -p "shard db type? (empty = same as main db) " DBTYPESHARD
read -p "shard db host? (empty = same as main db) " DBHOSTSHARD
read -p "shard db name? (empty = same as main db) " DBNAMESHARD
read -p "shard db username? (empty = same as main db) " DBUSERSHARD
read -p "shard db password? (empty = same as main db) " DBPASSSHARD
if [[ ! $DBTYPESHARD ]]; then
  DBTYPESHARD=$DBTYPE
fi
if [[ ! $DBHOSTSHARD ]]; then
  DBHOSTSHARD=$DBHOST
fi
if [[ ! $DBNAMESHARD ]]; then
  DBNAMESHARD=$DBNAME
fi
if [[ ! $DBUSERSHARD ]]; then
  DBUSERSHARD=$DBUSER
fi
if [[ ! $DBPASSSHARD ]]; then
  DBPASSSHARD=$DBPASS
fi

# write config file
sed \
	-e "s/\[DBTYPE\]/$DBTYPE/g" \
	-e "s/\[DBHOST\]/$DBHOST/g" \
	-e "s/\[DBNAME\]/$DBNAME/g" \
	-e "s/\[DBUSER\]/$DBUSER/g" \
	-e "s/\[DBPASS\]/$DBPASS/g" \
	-e "s/\[DBTYPESHARD\]/$DBTYPESHARD/g" \
	-e "s/\[DBHOSTSHARD\]/$DBHOSTSHARD/g" \
	-e "s/\[DBNAMESHARD\]/$DBNAMESHARD/g" \
	-e "s/\[DBUSERSHARD\]/$DBUSERSHARD/g" \
	-e "s/\[DBPASSSHARD\]/$DBPASSSHARD/g" \
$DIR/../config/db.sample > $DIR/../config/db.php
