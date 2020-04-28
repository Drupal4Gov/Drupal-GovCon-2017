<?php

namespace Drupal;

use Drupal\DrupalExtension\Context\RawDrupalContext;
use PHPUnit\Framework\Assert;
use Drupal\user\Entity\Role;
use Behat\Gherkin\Node\TableNode;
use Drupal\node\Entity\NodeType;
use Drupal\media\Entity\MediaType;
use Drupal\block_content\Entity\BlockContentType;

/**
 * FeatureContext class defines custom step definitions for Behat.
 */
class FeatureContext extends RawDrupalContext {

  /**
   * Every scenario gets its own context instance.
   *
   * You can also pass arbitrary arguments to the
   * context constructor through behat.yml.
   */
  public function __construct() {

  }

  /**
   * Entity Functions.
   */

  /**
   * @Given the :arg1 content type exists
   *
   * Examples:
   * Given the "blog" content type exists
   *
   * @throws \Exception;
   */
  public function contentTypeExists($string) {
    $node_type = NodeType::load($string);
    if (empty($node_type)) {
      throw new \Exception('Content type ' . $string . ' does not exist.');
    }
  }

  /**
   * @Given the :arg1 media type exists
   *
   * Examples:
   * Given the "image" media type exists
   *
   * @throws \Exception;
   */
  public function mediaTypeExists($string) {
    $media_type = MediaType::load($string);
    if (empty($media_type)) {
      throw new \Exception('Media type ' . $string . ' does not exist.');
    }
  }

  /**
   * @Given the :arg1 block_content type exists
   *
   * Examples:
   * Given the "hero" block_content type exists
   *
   * @throws \Exception;
   */
  public function blockTypeExists($string) {
    $block_type =  BlockContentType::load($string);
    if (empty($block_type)) {
      throw new \Exception('Block Content type ' . $string . ' does not exist.');
    }
  }

  /**
   * Check for presence of a field on a bundle.
   *
   * Examples:
   * Then the field "body" is present on the "blog" "node" type
   * Then the field "body" is present on the "hero" "block_content" type
   * Then the field "body" is present on the "slide" "paragraph" type
   * Then the field "body" is present on the "image" "media" type
   * Then the field "body" is present on the "tag" "vocabulary" type
   *
   * @Then the field :arg1 is present on the :arg2 :arg3 type
   */
  public function isField($field_name, $bundle, $entity) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions($entity, $bundle);
    if (empty($bundle_fields[$field_name])) {
      Assert::assertEmpty($bundle_fields, $field_name . ' is not present on the ' . $entity . " " . $bundle);
    }
  }

  /**
   * Check if a present field is required on a bundle.
   *
   * Examples:
   * Then the field "body" is required on the "blog" "node" type
   * Then the field "body" is required on the "hero" "block_content" type
   * Then the field "body" is required on the "slide" "paragraph" type
   * Then the field "body" is required on the "image" "media" type
   * Then the field "body" is required on the "tag" "vocabulary" type
   *
   * @Then the field :arg1 is required on the :arg2 :arg3 type
   */
  public function isRequiredField($field_name, $bundle, $entity) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions($entity, $bundle);
    $field_definition = $bundle_fields[$field_name];
    $setting = $field_definition->isRequired();
    Assert::assertNotEmpty($setting, 'Field ' . $field_name . ' is not required.');
  }

  /**
   * Check if a present field is not required on a bundle.
   *
   * Examples:
   * Then the field "body" is not required on the "blog" "node" type
   * Then the field "body" is not required on the "hero" "block_content" type
   * Then the field "body" is not required on the "slide" "paragraph" type
   * Then the field "body" is not required on the "image" "media" type
   * Then the field "body" is not required on the "tag" "vocabulary" type
   *
   * @Then the field :arg1 is not required on the :arg2 :arg3 type
   */
  public function isNotRequiredField($field_name, $bundle, $entity) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions($entity, $bundle);
    $field_definition = $bundle_fields[$field_name];
    $setting = $field_definition->isRequired();
    Assert::assertNotEmpty($setting, 'Field ' . $field_name . ' is not required.');
  }

  /**
   * Check a reference field's target bundle.
   *
   * Examples:
   * Then the field "categories" on the "blog" "node" type allows references to "categories"
   * Then the field "categories" on the "hero" "block_content" type allows references to "categories"
   * Then the field "categories" on the "slide" "paragraph" type allows references to "categories"
   * Then the field "categories" on the "image" "media" type allows references to "categories"
   * Then the field "categories" on the "tag" "vocabulary" type allows references to "categories"
   *
   * @Then the field :arg1 on the :arg2 :arg3 type should allow references to :arg4
   */
  public function fieldAllowsEntityReferences($field_name, $bundle, $entity, $reference_bundle) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions($entity, $bundle);
    $field_definition = $bundle_fields[$field_name];
    $settings = $field_definition->getSettings();
    if (!empty($settings['handler_settings']['target_bundles'])) {
      $target_bundles = $settings['handler_settings']['target_bundles'];
    }
    elseif (!empty($settings['handler_settings']['target_bundles_drag_drop'])) {
      $target_bundles = $settings['handler_settings']['target_bundles_drag_drop'];
      foreach ($target_bundles as $key=>$bundle) {
        $target_bundles[$key] = $key;
      }
    }
    else {
      return false;
    }
    Assert::assertContains(trim($reference_bundle), $target_bundles, $field_name . ' does not allow references to ' . trim($reference_bundle) . ' content');
  }

  /**
   * Check if a particular field is visible on a particular entity display mode
   *
   * Examples:
   * Then the display "teaser" on the "blog" "node" type should display the "field_status" field
   * Then the display "teaser" on the "hero" "block_content" type should display the "field_status" field
   * Then the display "teaser" on the "slide" "paragraph" type should display the "field_status" field
   * Then the display "teaser" on the "image" "media" type should display the "field_status" field
   * Then the display "teaser" on the "tag" "vocabulary" type should display the "field_status" field
   *
   * @Then the display :arg1 on the :arg2 :arg3 type should display the :arg4 field
   *
   */
  public function nodeFieldVisibile($display, $bundle, $entity, $field_name) {
    $storage = \Drupal::entityTypeManager()->getStorage('entity_view_display');
    $view_display = $storage->load("$entity.$bundle.$display");
    $component = $view_display->getComponent($field_name);
    Assert::assertContains('content', $component['region']);
  }

  /**
   * Check if a particular field is not visible on a particular entity display mode
   *
   * Examples:
   * Then the display "teaser" on the "blog" "node" type should not display the "field_status" field
   * Then the display "teaser" on the "hero" "block_content" type should not display the "field_status" field
   * Then the display "teaser" on the "slide" "paragraph" type should not display the "field_status" field
   * Then the display "teaser" on the "image" "media" type should not display the "field_status" field
   * Then the display "teaser" on the "tag" "vocabulary" type should not display the "field_status" field
   *
   * @Then the display :arg1 on the :arg2 :arg3 type should not display the :arg4 field
   */
  public function nodeFieldNotVisibile($display, $bundle, $entity, $field_name) {
    $storage = \Drupal::entityTypeManager()->getStorage('entity_view_display');
    $view_display = $storage->load("$entity.$bundle.$display");
    $component = $view_display->get('hidden');
    Assert::assertEquals(true, $component[$field_name]);
  }

  /**
   *
   * Checks the cardinality of a field on a given bundle.
   *
   * Examples:
   * The field "categories" on the "node" bundle has a cardinality of "-1".
   * The field "categories" on the "block_content" bundle has a cardinality of "-1".
   * The field "categories" on the "paragraph" bundle has a cardinality of "-1".
   * The field "categories" on the "media" bundle has a cardinality of "-1".
   * The field "categories" on the "vocabulary" bundle has a cardinality of "-1".
   *
   * @Then the field :arg1 on the :arg2 bundle has a cardinality of :arg3
   *
   */
  public function checkCardinality($field, $bundle, $cardinality) {
    $config = $this->checkCardinality($bundle, $field, $cardinality);
    Assert::assertEquals(
      $cardinality,
      $config,
      "The $field does not have the correct cardinality. It should be $cardinality but in reality is $config."
    );
  }

  /**
   * Checks the maximum length of a field on a given bundle.
   *
   * Examples:
   * The field "title" on the "node" bundle has a maximum length of "100"
   * The field "title" on the "block_content" bundle has a maximum length of "100"
   * The field "title" on the "paragraph" bundle has a maximum length of "100"
   * The field "title" on the "media" bundle has a maximum length of "100"
   * The field "title" on the "vocabulary" bundle has a maximum length of "100"
   *
   * @Then the field :arg1 on the :arg2 :arg3 type has a maximum length of :arg4
   */
  public function nodeFieldLengthLimit($field_name, $bundle, $entity, $length) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions($entity, $bundle);
    $field_definition = $bundle_fields[$field_name];
    $settings = $field_definition->getSettings();
    Assert::assertEquals($length, $settings['max_length']);
  }

  /**
   * @Then I visit the last created :arg1
   *
   * Locate the last created node or media and then redirect to it.
   *
   * Examples:
   * Then I visit the last created node.
   * Then I visit the last created media.
   */
  public function iVisitLatestContent($bundle) {
    switch ($bundle) {
      case "node":
      default:
        $id = $this->getLastCreatedNode();
        break;
      case "media":
        $id = $this->getLastCreatedMedia();
        break;
    }
    $this->getSession()->visit($this->locatePath("$bundle/$id"));

  }

  /**
   * Permission Functions.
   */

  /**
   * @Given the following roles have these permissions:
   *
   * Examples:
   * Given the following roles have these permissions:
   * | role                  | permission                                  |
   * | anonymous             | access content                              |
   * | authenticated         | access content                              |
   * | reviewer              | use content_workflow transition ready_ready |
   */
  public function roleUserPermissions(TableNode $rolesTable) {
    foreach ($rolesTable as $rolePermission) {
      $role = $rolePermission['role'];
      $permission = $rolePermission['permission'];
      $this->roleHasPermission($role, $permission);
    }
  }

  /**
   * @Given the following roles do not have these permissions:
   *
   * Examples:
   * Given the following roles do not have these permissions:
   * | role                  | permission                                  |
   * | anonymous             | access content                              |
   * | authenticated         | access content                              |
   * | reviewer              | use content_workflow transition ready_ready |
   */
  public function roleUserPermissionsNot(TableNode $rolesTable) {
    foreach ($rolesTable as $rolePermission) {
      $role = $rolePermission['role'];
      $permission = $rolePermission['permission'];
      $this->roleDoesNotHavePermission($role, $permission);
    }
  }

  /**
   * @Then :arg1 role has permission to :arg2
   *
   * Examples:
   * Then the "reviewer" role has permission to "access content"
   */
  public function checkRolePermissions($role, $permission) {
    $this->roleHasPermission($role, $permission);
  }

  /**
   * @Then :arg1 role does not have permission to :arg2
   *
   * Examples:
   * Then the "reviewer" role does not have permission to "access content"
   */
  public function checkRoleDoesNotHavePermission($role, $permission) {
    $this->roleDoesNotHavePermission($role, $permission);
  }

  /**
   * Checks that only valid roles have permission to execute certain content actions
   *
   * Examples:
   * | role                    | permission |
   * | author           	     | create     |
   * | author           	     | edit own   |
   * | editor           	     | edit any   |
   * | content_administrator   | create     |
   * | content_administrator	 | edit own   |
   * | content_administrator	 | edit any   |
   *
   * @Given that only the following roles have content permissions for the :arg1 content type:
   *
   */
  public function roleOnlyContentPermissions($bundle, TableNode $rolesTable) {
    $allowed_roles = array();
    foreach ($rolesTable as $rolePermission) {
      $role = $rolePermission['role'];
      $permission = $rolePermission['permission'] . ' ' . $bundle . ' content';
      $this->roleHasPermission($role, $permission);
      $allowed_roles[] = $role;
    }
    $allowed_roles[] = 'administrator';

    $all_roles = $this->getRoles();
    foreach ($all_roles as $role) {
      if (!in_array($role, $allowed_roles)) {
        $this->roleDoesNotHavePermission($role, $permission);
      }
    }
  }

  /**
   * Helper Functions Only below.
   */


  /**
   * Get most recent node id.
   *
   */
  public static function getLastCreatedNode() {
    $query = \Drupal::database()->select('node_field_data', 'nfd');
    $query->addField('nfd', 'nid');
    $query->range(0, 1);
    $query->orderBy("nid", 'DESC');
    $nid = $query->execute()->fetchField();

    return $nid;
  }

  /**
   * Get most recent media id.
   *
   */
  public static function getLastCreatedMedia() {
    $query = \Drupal::database()->select('media_field_data', 'mfd');
    $query->addField('mfd', 'mid');
    $query->range(0, 1);
    $query->orderBy("mid", 'DESC');
    $mid = $query->execute()->fetchField();

    return $mid;
  }

  /**
   * Users with the $role should have the $permission.
   */
  public function roleHasPermission($role, $permission) {
    $roleObj = Role::load($role);
    Assert::assertNotEmpty($roleObj->hasPermission($permission), $role . ' role does not have permission to ' . $permission);
  }

  /**
   * Users with the $role should not have the $permission.
   */
  public function roleDoesNotHavePermission($role, $permission) {
    $roleObj = Role::load($role);
    Assert::assertEmpty($roleObj->hasPermission($permission), $role . ' role has permission to ' . $permission . ', but should not.');
  }

  /**
   * Get all user roles.
   */
  public function getRoles() {
    $roles = user_roles();
    $roles = array_keys($roles);
    return $roles;
  }

  /**
   * adds a breakpoints
   * stops the execution until you hit enter in the console
   * @Then /^breakpoint/
   */
  public function breakpoint() {
    fwrite(STDOUT, "\033[s    \033[93m[Breakpoint] Press \033[1;93m[RETURN]\033[0;93m to continue...\033[0m");
    while (fgets(STDIN, 1024) == '') {}
    fwrite(STDOUT, "\033[u");
    return;
  }

}
