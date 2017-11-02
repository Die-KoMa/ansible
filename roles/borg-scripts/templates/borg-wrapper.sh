#!/bin/bash

{{ ansible_managed|comment }}

export BORG_PASSPHRASE='{{borg_password|mandatory}}'
export BORG_REPO='{{borg_host|mandatory}}:{{borg_remote_path|mandatory}}'

borg "$@"
