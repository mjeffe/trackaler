#!/usr/bin/env bash
#
# I've been experimenting with GitHub Actions for CI/CD, so this is more like a
# "post" deploy script for the GHA deploy stuff.
#
# See notes in the head of .github/workflows/cicd.yml
#

# default to staging
export DEPLOY_TO=${1:=stg}

export PATH="$HOME/bin:$PATH"
PHP=`which php-8.0`
COMPOSER=`which composer-8.0`

if [ "$PHP"x = 'x' ]; then
    echo "Unable to locate php binary"
    exit 1
fi
if [ "$COMPOSER"x = 'x' ]; then
    echo "Unable to locate composer binary"
    exit 1
fi

$PHP $COMPOSER install
$PHP artisan migrate --force
$PHP artisan config:cache
$PHP artisan route:cache
$PHP artisan view:cache

if [ $DEPLOY_TO = 'stg' ]; then
    $PHP artisan db:seed
fi


