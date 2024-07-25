#!/usr/bin/env bash

DB_DNS="$(/usr/bin/printenv CONFIG_DB_DSN)"

# extract the protocol
proto="`echo $DB_DNS | grep '://' | sed -e's,^\(.*://\).*,\1,g'`"
# remove the protocol
url=`echo $DB_DNS | sed -e s,$proto,,g`

# extract the user and password (if any)
userpass="`echo $url | grep @ | cut -d@ -f1`"
DB_PASSWORD=`echo $userpass | grep : | cut -d: -f2`
if [ -n "$DB_PASSWORD" ]; then
    DB_USERNAME=`echo $userpass | grep : | cut -d: -f1`
else
    DB_USERNAME=$userpass
fi

# extract the host -- updated
hostport=`echo $url | sed -e s,$userpass@,,g | cut -d/ -f1`
DB_PORT=`echo $hostport | grep : | cut -d: -f2`
if [ -n "$DB_PORT" ]; then
    DB_HOST=`echo $hostport | grep : | cut -d: -f1`
else
    DB_HOST=$hostport
fi

# extract the path (if any)
DB_NAME="`echo $url | grep / | cut -d/ -f2-`"

export PGPASSWORD=$DB_PASSWORD

DB_EXISTS="SELECT 1 FROM pg_database WHERE datname = '$DB_NAME'"
DB_REQUEST="CREATE DATABASE "$DB_NAME" WITH ENCODING = 'UTF8'"

psql -h $DB_HOST -p $DB_PORT -U $DB_USERNAME postgres -tc "$DB_EXISTS" | grep -q 1 || psql -h $DB_HOST -p $DB_PORT -U $DB_USERNAME postgres -c "$DB_REQUEST"
