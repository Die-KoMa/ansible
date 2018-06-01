#!/bin/bash

{{ ansible_managed|comment }}

if ss --listening --no-header sport = :http | grep LISTEN > /dev/null; then
  certbot certonly
else
  certbot certonly --http-01-port 80
fi

{% if use_haproxy|default(False) %}
mkdir -p /etc/haproxy/certs
for path in /etc/letsencrypt/live/*; do
  cat ${path}/{fullchain,privkey}.pem > /etc/haproxy/certs/$(basename "$path").pem
done
if command -v haproxy >/dev/null; then
  systemctl reload haproxy.service
fi
{% endif %}
