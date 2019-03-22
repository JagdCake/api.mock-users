#!/bin/bash

table_name="$1"
from_db_name="$2"
to_db_name="$3"

if [ $# -eq 3 ]; then
    if [ ! -f ./dump ]; then
        pg_dump -O -t "$table_name" "$from_db_name" > ./dump
    fi
else
    echo 'Usage: ./transfer_db.sh [from [table_name]] [of [database name]] [to [database name]]'
    exit 1
fi &&

read -p "Copy table dump to container (name): " container &&

docker cp ./dump "$container":/home/ &&
docker exec -it "$container" sh -c "psql -h localhost -U ${to_db_name} < /home/dump" &&
docker exec -it "$container" rm /home/dump

rm ./dump

