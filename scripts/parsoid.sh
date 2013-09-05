#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# ask for parsoid details
read -p "parsoid url? (e.g. http://localhost:8000; empty for no Parsoid/VisualEditor support) " PARSOIDURL
read -p "parsoid prefix? (empty for localhost) " PARSOIDPREFIX
if [[ ! $PARSOIDPREFIX ]]; then
  PARSOIDPREFIX="localhost"
fi

# write config file
sed -e "s/\[PARSOIDURL\]/$(echo $PARSOIDURL | sed -e 's/[\/&]/\\&/g')/g" -e "s/\[PARSOIDPREFIX\]/$PARSOIDPREFIX/g" $DIR/../config/parsoid.sample > $DIR/../config/parsoid.php
