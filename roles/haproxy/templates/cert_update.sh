#!/bin/bash

{{ ansible_managed|comment }}

for path in /etc/letsencrypt/live/*; do
  if [[ -f ${path}/fullchain.pem ]]; then
    cat ${path}/{fullchain,privkey}.pem > "/etc/haproxy/certs/$(basename "$path").pem"
  fi
done

systemctl is-active --quiet haproxy.service && systemctl reload haproxy.service
