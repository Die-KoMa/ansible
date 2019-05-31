#!/bin/bash

{{ ansible_managed|comment }}

if ss --listening --no-header sport = :http | grep LISTEN > /dev/null; then
  certbot certonly $@
else
  certbot certonly --http-01-port 80 $@
fi
