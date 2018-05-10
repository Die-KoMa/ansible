#!/bin/bash

{{ ansible_managed|comment }}

mw_path="{{mediawiki_path}}"
mw_ro_lockdir="{{mediawiki_path}}/{{mediawiki_ro_lock_dir}}"
mw_ro_filename="{{mediawiki_ro_file}}"

mw_lock_msg="Backup"
mw_backup_name="mediawiki"
mw_db_name="komapedia"

lock () {
  mkdir "$mw_ro_lockdir"
}

unlock () {
  rm "$mw_ro_lockdir/$mw_ro_filename"
  rmdir "$mw_ro_lockdir"
}

clean_dump_dir () {
  local dump_dir="$mw_path/$1_dump"
  rm -r "$dump_dir"
  mkdir "$dump_dir"
  echo "Deny from all" > "$dump_dir/.htaccess"
  echo "$dump_dir"
}

dump_db () {
  local dump_dir="$(clean_dump_dir db)"
  echo "$dump_dir"
  echo dump_db
  mysqldump --single-transaction "$mw_db_name" > "$dump_dir/dump_$(date -I).sql"
}

dump_content () {
  local dump_dir="$(clean_dump_dir content)"
  echo "$dump_dir"
  echo dump_content
}

borg_backup () {
  borg-create "$mw_backup_name" "$mw_path"
}

backup () {
  if ! lock; then
    echo "The mediawiki is already in read only mode."
    echo "Abort"
    exit 1
  fi
  echo "$mw_lock_msg" > "$mw_ro_lockdir/$mw_ro_filename"

  # give everything time to finish
  sleep 5

  dump_db
  dump_content
  borg_backup

  unlock
}

backup
