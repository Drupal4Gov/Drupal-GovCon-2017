<?php

/**
 * @file
 * Contains the theme's settings form.
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function twentyeighteen_form_system_theme_settings_alter(&$form, FormStateInterface &$form_state, $form_id = NULL) {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  // Create the form using Forms API: http://api.drupal.org/api/7
  /* -- Delete this line if you want to use this setting
  $form['twentyeighteen_example'] = [
  '#type'          => 'checkbox',
  '#title'         => t('twentyeighteen sample setting'),
  '#default_value' => theme_get_setting('twentyeighteen_example'),
  '#description'   => t("This example option doesn't do anything."),
  ];
  // */

  /* -- Delete this line if you want to remove this base theme setting.
  // We don't need breadcrumbs to be configurable on this site.
  unset($form['breadcrumb']);
  // */

  // We are editing the $form in place, so we don't need to return anything.
}
