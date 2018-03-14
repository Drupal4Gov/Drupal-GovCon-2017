<?php

/**
 * @file
 * Implmentation of wbm_to_cm drush commands.
 *
 * Drush command to re-save all moderated entities and capture values in
 * content moderation.
 * PHP version 5
 */

use Drupal\Core\Database\Database;

/**
 * Sets up the wbm_to_cm drush commands.
 *
 * Implements hook_drush_command().
 *
 * @return array
 *   Return array of Items.
 */
function wbm_to_cm_drush_command() {
  $items['wbm-to-cm-node-re-save'] = [
    'description' => dt('Update nodes to content moderation.'),
    'aliases' => ['wtc-nr'],
    'arguments' => [
      'type' => 'Nodes of this type will be updated.',
    ],
  ];
  $items['wbm-to-cm-clear'] = [
    'description' => dt('Clear all workbench moderation state values.'),
    'aliases' => ['wtc-c'],
  ];
  $items['wbm-to-cm-profile-re-save'] = [
    'description' => dt('Update nodes to content moderation.'),
    'aliases' => ['wtc-pr'],
  ];
  $items['wbm-to-cm-db-query'] = [
    'description' => dt('Returns information from the database for
     verification purposes.'),
    'aliases' => ['wtc-dq'],
    'arguments' => [
      'table' => 'The table to query.',
      'type'  => 'The entity type to query.',
    ],
  ];
  $items['wbm-to-cm-content-type-list'] = [
    'description' => dt("Show a list of available content types."),
    'aliases' => ['ctl'],
  ];
  return $items;

}

/**
 * Callback function for drush wbm-to-cm-node-re-save.
 *
 * Callback is called by using drush_hook_command() where
 * hook is the name of the module (wbm-to-cm) and command is the name of
 * the Drush command with all "-" characters converted to "_" characters.
 *
 * @param string $type
 *   Test
 *   The flag handler to check.
 */
function drush_wbm_to_cm_node_re_save($type) {
  $id = db_query('SELECT MAX(id) FROM {content_moderation_state}')->fetchField() + 1;
  $revision_id = db_query('SELECT MAX(revision_id) FROM {content_moderation_state}')->fetchField() + 1;

  $nids = \Drupal::entityQuery('node')->condition('type', $type)->execute();

  echo "************************************************\n";
  echo "     Migrating " . $type . " nodes.             \n";
  echo "************************************************\n";

  foreach ($nids as $nid) {
    echo "Migrating node: " . $nid . "\n";
    // Retrieves data from node_field_data table.
    $node_connection = Database::getConnection();

    $node_data = $node_connection->select('node_field_data', 'nfd')
      ->fields('nfd', [
        'nid',
        'vid',
        'moderation_state',
        'langcode',
        'uid',
        'default_langcode',
        'revision_translation_affected',
      ])
      ->condition('nid', $nid, '=');

    // Execute the statement.
    $data = $node_data->execute();

    // Get all the results.
    $node_data_results = $data->fetchAll(\PDO::FETCH_OBJ);

    foreach ($node_data_results as $node_data_result) {
      $conn = Database::getConnection();
      $conn->insert('content_moderation_state_field_data')
        ->fields([
          'id' => $id,
          'revision_id' => $revision_id,
          'langcode' => $node_data_result->langcode,
          'uid' => $node_data_results[0]->uid,
          'workflow' => '00c7e3ae',
          'moderation_state' => $node_data_result->moderation_state,
          'content_entity_type_id' => 'node',
          'content_entity_id' => $nid,
          'content_entity_revision_id' => $node_data_result->vid,
          'default_langcode' => $node_data_result->default_langcode,
          'revision_translation_affected' => $node_data_result->revision_translation_affected,
        ])
        ->execute();
    }

    // Load all revisions for a node.
    $node_revisions_connection = Database::getConnection();
    $node_revisions = $node_revisions_connection->select('node_revision', 'nr')
      ->fields('nr')
      ->condition('nid', $nid)
      ->execute()
      ->fetchAllAssoc('vid');

    foreach ($node_revisions as $node_revision) {
      $vid = $node_revision->vid;

      // Content moderation state field revision table.
      $revision_connection = Database::getConnection();

      $revisions = $revision_connection->select('node_field_revision', 'nfr')
        ->fields('nfr',
          [
            'nid',
            'vid',
            'moderation_state',
            'langcode', 'uid',
            'default_langcode',
            'revision_translation_affected',
          ])
        ->condition('vid', $vid, '=');

      // Execute the statement.
      $data = $revisions->execute();

      // Get all the results.
      $revision_results = $data->fetchAll(\PDO::FETCH_OBJ);

      // print_r($revision_results);
      // continue;
      foreach ($revision_results as $revision_result) {
        $conn = Database::getConnection();
        $conn->insert('content_moderation_state_field_revision')
          ->fields([
            'id' => $id,
            'revision_id' => $revision_id,
            'langcode' => $revision_result->langcode,
            'uid' => $revision_result->uid,
            'workflow' => '00c7e3ae',
            'moderation_state' => $revision_result->moderation_state,
            'content_entity_type_id' => 'node',
            'content_entity_id' => $nid,
            'content_entity_revision_id' => $vid,
            'default_langcode' => $revision_result->default_langcode,
            'revision_translation_affected' => $revision_result->revision_translation_affected,
          ])
          ->execute();

      }

      // Content moderation state revision table.
      $node_revisions = $revision_connection->select('node_revision', 'nr')
        ->fields('nr', ['langcode'])
        ->condition('vid', $vid, '=');

      // Execute the statement.
      $data = $node_revisions->execute();

      // Get all the results.
      $node_revision_results = $data->fetchAll(\PDO::FETCH_OBJ);

      foreach ($node_revision_results as $node_revision_result) {
        $conn = Database::getConnection();
        $conn->insert('content_moderation_state_revision')
          ->fields([
            'id' => $id,
            'revision_id' => $revision_id,
            'langcode' => $node_revision_result->langcode,
          ])
          ->execute();
      }
      $revision_id++;
    }
    $revision_id = $revision_id - 1;
    $uuid_service = \Drupal::service('uuid');
    $uuid = $uuid_service->generate();

    $conn = Database::getConnection();
    $conn->insert('content_moderation_state')
      ->fields([
        'id' => $id,
        'revision_id' => $revision_id,
        'uuid' => $uuid,
        'langcode' => $node_data_results[0]->langcode,
      ])
      ->execute();
    $revision_id++;
    $id++;
  }
}

/**
 * Callback function for drush wbm-to-cm-profile-re-save.
 *
 * Callback is called by using drush_hook_command() where
 * hook is the name of the module (wbm-to-cm) and command is the name of
 * the Drush command with all "-" characters converted to "_" characters.
 */
function drush_wbm_to_cm_profile_re_save() {
  $id = db_query('SELECT MAX(id) FROM {content_moderation_state}')->fetchField() + 1;
  $revision_id = db_query('SELECT MAX(revision_id) FROM {content_moderation_state}')->fetchField() + 1;

  $pids = \Drupal::entityQuery('profile')->execute();

  echo "************************************************\n";
  echo "                Migrating profiles.             \n";
  echo "************************************************\n";

  foreach ($pids as $key => $pid) {

    // Load all revisions for a profile.
    $profile_revisions_connection = Database::getConnection();
    $profile_revisions = $profile_revisions_connection->select('profile_revision', 'pr')
      ->fields('pr')
      ->condition('profile_id', $pid)
      ->execute()
      ->fetchAllAssoc('revision_id');

    foreach ($profile_revisions as $pr_key => $profile_revision) {

      // Retrieves data from profile_revision table.
      $revision_connection = Database::getConnection();

      $revisions = $revision_connection->select('profile_revision', 'r')
        ->fields('r', ['profile_id', 'revision_id', 'moderation_state', 'uid'])
        ->condition('revision_id', $pr_key, '=');

      // Execute the statement.
      $data = $revisions->execute();

      // Get all the results.
      $revision_results = $data->fetchAll(\PDO::FETCH_OBJ);

      $conn = Database::getConnection();
      $conn->insert('content_moderation_state_field_revision')
        ->fields([
          'id' => $id,
          'revision_id' => $revision_id,
          'langcode' => 'und',
          'uid' => $revision_results[0]->uid,
          'workflow' => 'ibm_access_moderation',
          'moderation_state' => $revision_results[0]->moderation_state,
          'content_entity_type_id' => 'profile',
          'content_entity_id' => $pid,
          'content_entity_revision_id' => $revision_results[0]->revision_id,
          'default_langcode' => 1,
          'revision_translation_affected' => 1,
        ])
        ->execute();

      $conn = Database::getConnection();
      $conn->insert('content_moderation_state_revision')
        ->fields([
          'id' => $id,
          'revision_id' => $revision_id,
          'langcode' => 'und',
        ])
        ->execute();

      $revision_id++;
    }
    $conn = Database::getConnection();
    $conn->insert('content_moderation_state_field_data')
      ->fields([
        'id' => $id,
        'revision_id' => $revision_id,
        'langcode' => 'und',
        'uid' => $revision_results[0]->uid,
        'workflow' => 'ibm_access_moderation',
        'moderation_state' => $revision_results[0]->moderation_state,
        'content_entity_type_id' => 'profile',
        'content_entity_id' => $pid,
        'content_entity_revision_id' => $key,
        'default_langcode' => 1,
        'revision_translation_affected' => 1,
      ])
      ->execute();

    $uuid_service = \Drupal::service('uuid');
    $uuid = $uuid_service->generate();

    $conn = Database::getConnection();
    $conn->insert('content_moderation_state')
      ->fields([
        'id' => $id,
        'revision_id' => $revision_id,
        'uuid' => $uuid,
        'langcode' => 'und',
      ])
      ->execute();
    $id++;
  }
}

/**
 * Callback function for drush wbm-to-cm-clear.
 *
 * Callback is called by using drush_hook_command() where
 * hook is the name of the module (wbm-to-cm) and command is the name of
 * the Drush command with all "-" characters converted to "_" characters.
 */
function drush_wbm_to_cm_clear() {

  // Delete old workbench moderation values.
  \Drupal::database()->update('node_field_revision')
    ->fields([
      'moderation_state' => NULL,
    ])
    ->execute();
  \Drupal::database()->update('node_field_data')
    ->fields([
      'moderation_state' => NULL,
    ])
    ->execute();
}

/**
 * Callback function for drush wbm-to-cm-db-query.
 *
 * Callback is called by using drush_hook_command() where
 * hook is the name of the module (wbm-to-cm) and command is the name of
 * the Drush command with all "-" characters converted to "_" characters.
 *
 * @param string $type
 *   Test
 *   The flag handler to check.
 */
function drush_wbm_to_cm_db_query($table, $type) {

  if (($table == 'node_field_revision' && $type == 'node') || $table == 'content_moderation_state_field_revision' && $type == 'node') {
    $connection = Database::getConnection();

    $query = $connection->select($table, 't')
      ->condition('moderation_state', 'draft', '=');
    $query->addExpression('COUNT(*)');
    $count_draft = $query->execute()->fetchField();

    $query = $connection->select($table, 't')
      ->condition('moderation_state', 'needs_review', '=');
    $query->addExpression('COUNT(*)');
    $count_needs_review = $query->execute()->fetchField();

    $query = $connection->select($table, 't')
      ->condition('moderation_state', 'returned', '=');
    $query->addExpression('COUNT(*)');
    $count_returned = $query->execute()->fetchField();

    $query = $connection->select($table, 't')
      ->condition('moderation_state', 'published', '=');
    $query->addExpression('COUNT(*)');
    $count_published = $query->execute()->fetchField();

    echo "Items in draft: " . $count_draft . "\n";
    echo "Items in needs review: " . $count_needs_review . "\n";
    echo "Items in returned: " . $count_returned . "\n";
    echo "Items in published: " . $count_published . "\n";
  }

  if (($table == 'profile_revision' && $type == 'profile') || ($table == 'content_moderation_state_field_revision' && $type == 'profile')) {
    $connection = Database::getConnection();

    $query = $connection->select($table, 't')
      ->condition('moderation_state', 'approved', '=');
    $query->addExpression('COUNT(*)');
    $count_approved = $query->execute()->fetchField();

    $query = $connection->select($table, 't')
      ->condition('moderation_state', 'rejected', '=');
    $query->addExpression('COUNT(*)');
    $count_rejected = $query->execute()->fetchField();

    $query = $connection->select($table, 't')
      ->condition('moderation_state', 'request_access', '=');
    $query->addExpression('COUNT(*)');
    $count_request_access = $query->execute()->fetchField();

    $query = $connection->select($table, 't')
      ->condition('moderation_state', 'revoke_access', '=');
    $query->addExpression('COUNT(*)');
    $count_revoke_access = $query->execute()->fetchField();

    echo "Items in approved: " . $count_approved . "\n";
    echo "Items in rejected: " . $count_rejected . "\n";
    echo "Items in request access: " . $count_request_access . "\n";
    echo "Items in revoke access: " . $count_revoke_access . "\n";
  }
}

/**
 * Stuff w/ drush.
 */
function drush_wbm_to_cm_content_type_list() {
  $content_types = array_keys(node_type_get_types());
  sort($content_types);

  drush_print(dt("Machine name"));
  drush_print(implode("\r\n", $content_types));
}
