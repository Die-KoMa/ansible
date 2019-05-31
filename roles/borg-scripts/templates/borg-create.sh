#!/bin/bash

{{ ansible_managed|comment }}

borg-wrapper \
  create \
  -v \
  --stats \
  --compress zstd,20 \
  ::$1'-{now:%Y-%m-%d-%H:%M}' \
  "${@:2}"

# Use the `prune` subcommand to maintain {{borg_prune_keep_daily}} daily, {{borg_prune_keep_weekly}} weekly and {{borg_prune_keep_monthly}} montly
# archives of THIS machine. The '{hostname}-' prefix is very important to
# limit prune's operation to this machine's archives and not accidentaly prune
# other machine's archives also.
borg-wrapper \
  prune \
  -v \
  --list :: \
  --prefix "$1-" \
  --keep-daily={{borg_prune_keep_daily}} \
  --keep-weekly={{borg_prune_keep_weekly}}  \
  --keep-monthly={{borg_prune_keep_monthly}}
