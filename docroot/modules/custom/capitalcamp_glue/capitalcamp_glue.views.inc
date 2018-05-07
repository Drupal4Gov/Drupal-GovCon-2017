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
}
