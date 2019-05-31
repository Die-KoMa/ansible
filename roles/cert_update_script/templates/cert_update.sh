#!/bin/bash

{{ ansible_managed|comment }}


find "/etc/ssl/update.hooks/" -maxdepth 1 -type f -regex '.*/[^#.][^/]*[^~]' -executable 2>/dev/null | \
  while read -r script; do
    /bin/sh -c "$script"
  done
