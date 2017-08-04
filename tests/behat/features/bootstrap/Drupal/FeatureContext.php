<?php

namespace Drupal;

use Drupal\DrupalExtension\Context\RawDrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use PHPUnit_Framework_Assert;

/**
 * FeatureContext class defines custom step definitions for Behat.
 */
class FeatureContext extends RawDrupalContext implements SnippetAcceptingContext {

  /**
   * Every scenario gets its own context instance.
   *
   * You can also pass arbitrary arguments to the
   * context constructor through behat.yml.
   */
  public function __construct() {

  }

  /**
   * Checks if a field is present for users.
   *
   * @Then the field :arg1 is present for users
   */
  public function isUserField($field_name) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions('user', 'user');
    if (empty($bundle_fields[$field_name])) {
      throw new \Exception('Field ' . $field_name . ' is not required.');
    }
  }

  /**
   * Checks if a field is required for users.
   *
   * @Then the :arg1 field should be required for users
   */
  public function checkIsRequiredUserField($field_name) {
    $this->isRequiredUserField($field_name);
  }

  /**
   * Checks if a field is required for users.
   *
   * The $field_name field should be required for users.
   */
  public function isRequiredUserField($field_name) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions('user', 'user');
    $field_definition = $bundle_fields[$field_name];
    $setting = $field_definition->isRequired();
    PHPUnit_Framework_Assert::assertNotEmpty($setting, 'Field ' . $field_name . ' is not required.');
  }

}
