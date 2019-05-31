#!/bin/bash

{{ ansible_managed|comment }}

for path in /etc/letsencrypt/live/*; do
  cat ${path}/{fullchain,privkey}.pem > "/etc/haproxy/certs/$(basename "$path").pem"
done

systemctl is-active --quiet haproxy.service && systemctl reload haproxy.service
