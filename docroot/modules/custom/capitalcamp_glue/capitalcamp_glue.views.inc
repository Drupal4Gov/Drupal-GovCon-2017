<?php

/**
 * @file
 * Contains views api functions for capitalcamp_glue.
 */

/**
 * Implements hook_views_data_alter().
 */
function capitalcamp_glue_views_data_alter(array &$data) {
  $data['webform_submission']['attendee_name'] = [
    'title' => t('Attendee Name'),
    'field' => [
      'title' => t('Attendee Name'),
      'help' => t('Links a webform submission to a user profile.'),
      'id' => 'attendee_name',
    ],
  ];
  $data['webform_submission']['attendee_photo'] = [
    'title' => t('Attendee Photo'),
    'field' => [
      'title' => t('Attendee Photo'),
      'help' => t('Displays a user profile photo.'),
      'id' => 'attendee_photo',
    ],
  ];
  $data['node']['speakers'] = [
    'title' => t('All Speakers'),
    'field' => [
      'title' => t('All Speakers'),
      'help' => t('Displays a combination of primary and co-speakers in a single field..'),
      'id' => 'speakers',
    ],
  ];
  $data['node']['session_primary_links'] = [
    'title' => t('Session Primary Links'),
    'field' => [
      'title' => t('Session Primary Links'),
      'help' => t('Displays the session primary links if a user has a valid ticket'),
      'id' => 'session_primary_links',
    ],
  ];
  $data['node']['session_alt_links'] = [
    'title' => t('Session Alternate Links'),
    'field' => [
      'title' => t('Session Alternate Links'),
      'help' => t('Displays the session alternate links if a user has a valid ticket'),
      'id' => 'session_alt_links',
    ],
  ];
}
