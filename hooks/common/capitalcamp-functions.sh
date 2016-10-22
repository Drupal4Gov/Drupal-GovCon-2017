#!/bin/sh

env_refresh() {
  env=$1
  drush_alias=$2
#  email=""
#  key=""
  endpoint="https://cloudapi.acquia.com/v1"

# case ${env} in
#    "prod" )
#          echo "Making backup of Database..."
#          drush @${drush_alias} ac-database-instance-backup cbriver --endpoint=${endpoint} --email=${email} --key=${key}
#      * )
#  esac

  echo "Importing Config changes"
  drush @${drush_alias} --strict=0 config-import --partial --source=/mnt/www/html/capitalcamp.${env}/config/default -y

  echo "Run features revert ..."
  drush @${drush_alias} features-import-all

  echo "Making any necessary Drupal database updates..."
  drush @${drush_alias} updb --entity-updates -y

  echo "Run another features revert ..."
  drush @${drush_alias} features-import-all

  echo "Rebuilding Cache ..."
  drush @${drush_alias} cache-rebuild

  echo "Importing Config changes again ..."
  drush @${drush_alias} --strict=0 config-import --partial --source=/mnt/www/html/capitalcamp.${env}/config/default -y

  echo "Rebuilding Cache one last time ..."
  drush @${drush_alias} cache-rebuild

#  echo "Clearing Varnish..."
#  drush @${drush_alias} ac-domain-purge capitalcamp{env}.prod.acquia-sites.com --endpoint=${endpoint} --email=${email} --key=${key}
  echo "Deployment script run for ${env}";;

  case ${env} in
    "prod" )
          echo "Clearing Varnish..."
#          drush @${drush_alias} ac-domain-purge capitalcamp.prod.acquia-sites.com --endpoint=${endpoint} --email=${email} --key=${key}
#          echo "Deployment script run for ${env}";;
      * )
  esac
}
