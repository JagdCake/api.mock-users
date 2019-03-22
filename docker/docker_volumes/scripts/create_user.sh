#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username postgres --dbname postgres <<-EOSQL
    CREATE DATABASE mock_api;
    CREATE USER mock_api WITH ENCRYPTED PASSWORD '';
    GRANT ALL PRIVILEGES ON DATABASE mock_api TO mock_api;
EOSQL
