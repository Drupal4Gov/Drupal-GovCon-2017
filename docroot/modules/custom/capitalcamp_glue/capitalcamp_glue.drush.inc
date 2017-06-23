<?php

/**
 * @file
 * Provides customization for Entity type Message.
 */

/**
 * Implements hook_drush_sql_sync_sanitize() for capitalcamp_glue.
 */
function capitalcamp_glue_drush_sql_sync_sanitize() {
  // Uninstalls and clears config for the acquia_connector module.
  $acquia_connector_query = "UPDATE config set data = NULL WHERE name LIKE 'acquia_connector.settings';";
  drush_sql_register_post_sync_op('acquia_connector-sanitize', dt('Sanitize Acquia Connector'), $acquia_connector_query);
  exec("drush pm-uninstall acquia_connector -y");

  // Uninstalls and clears config for the cloudflare module.
  $cloudflare_query = "UPDATE config set data = NULL WHERE name LIKE 'cloudflare.settings';";
  drush_sql_register_post_sync_op('cloudflare-sanitize', dt('Sanitize Cloudflare'), $cloudflare_query);
  exec("drush pm-uninstall cloudflare -y");
}
