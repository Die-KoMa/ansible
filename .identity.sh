#!/bin/sh

cd $(dirname $(realpath $0))
gpg --batch --quiet --decrypt .identity.gpg
