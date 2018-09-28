<?php

namespace Drupal;

use Drupal\DrupalExtension\Context\RawDrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use PHPUnit\Framework\Assert;
use Behat\Gherkin\Node\TableNode;
use Drupal\user\Entity\Role;
use Drupal\node\Entity\NodeType;
use Drupal\block_content\Entity\BlockContentType;
use Drupal\paragraphs\Entity\ParagraphsType;
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
    Assert::assertNotEmpty($setting, 'Field ' . $field_name . ' is not required.');
  }

  /**
   * @Given the :arg1 content type exists
   */
  public function contentTypeExists($string) {
    $node_type =  NodeType::load($string);
    if (empty($node_type)) {
      throw new \Exception('Content type ' . $string . ' does not exist.');
    }
  }

  /**
   * @Given the :arg1 block type exists
   */
  public function blockTypeExists($string) {
    $block_type =  BlockContentType::load($string);
    if (empty($block_type)) {
      throw new \Exception('Block type ' . $string . ' does not exist.');
    }
  }

  /**
   * @Given the :arg1 paragraph type exists
   */
  public function paragraphTypeExists($string) {
    $paragraph_type =  ParagraphsType::load($string);
    if (empty($paragraph_type)) {
      throw new \Exception('Paragraph type ' . $string . ' does not exist.');
    }
  }

  /**
   * @Then the field :arg1 is present for the :arg2 content type
   */
  public function isNodeField($field_name, $node_type) {
    $this->isField($field_name, 'node', $node_type);
  }

  /**
   * The $field_name should be present on $entity_type $bundle.
   */
  public function isField($field_name, $bundle, $entity_type) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions($bundle, $entity_type);
    if (empty($bundle_fields[$field_name])) {
      Assert::assertEmpty($bundle_fields, $field_name . ' is not present on the ' . $entity_type . " " . $bundle);
    }
  }

  /**
   * @Then the :arg1 field on :arg2 content should allow references to :arg3 content/vocabulary (terms)
   */
  public function nodeCheckFieldAllowsEntityReferences($field_name, $node_type, $reference_bundles) {
    $reference_bundles = explode(',', $reference_bundles);
    $this->nodeFieldAllowsEntityReferences($field_name, $node_type, $reference_bundles);
  }

  /**
   * @Then the :arg1 field on :arg2 content should allow references to :arg3 paragraphs
   */
  public function nodeCheckFieldAllowsParagraphReferences($field_name, $paragraph_type, $reference_bundles) {
    $reference_bundles = explode(',', $reference_bundles);
    $this->nodeFieldAllowsEntityReferences($field_name, $paragraph_type, $reference_bundles);
  }

  /**
   * @Then the :arg1 field on :arg2 content should allow references to :arg3 media
   */
  public function nodeCheckMediaFieldAllowsEntityReferences($field_name, $node_type, $reference_bundles) {
    $reference_bundles = explode(',', $reference_bundles);
    $this->nodeFieldAllowsEntityReferences($field_name, $node_type, $reference_bundles);
  }

  /**
   * @Then the :arg1 field on :arg2 paragraph should allow references to :arg3 media
   */
  public function paragraphCheckMediaFieldAllowsEntityReferences($field_name, $paragraph_type, $reference_bundles) {
    $reference_bundles = explode(',', $reference_bundles);
    $this->paragraphFieldAllowsEntityReferences($field_name, $paragraph_type, $reference_bundles);
  }

  /**
   * @Then the :arg1 field on :arg2 blocks should allow references to :arg3 media
   */
  public function blockCheckMediaFieldAllowsEntityReferences($field_name, $paragraph_type, $reference_bundles) {
    $reference_bundles = explode(',', $reference_bundles);
    $this->blockFieldAllowsEntityReferences($field_name, $paragraph_type, $reference_bundles);
  }

  /**
   * @Then the :arg1 field on :arg2 blocks should allow references to :arg3 content/vocabulary (terms)
   */
  public function blockCheckFieldAllowsEntityReferences($field_name, $block_type, $reference_bundles) {
    $reference_bundles = explode(',', $reference_bundles);
    $this->blockFieldAllowsEntityReferences($field_name, $block_type, $reference_bundles);
  }

  /**
   * @Then the :arg1 field on :arg2 blocks should allow references to :arg3 paragraphs
   */
  public function blockCheckFieldAllowsParagraphReferences($field_name, $paragraph_type, $reference_bundles) {
    $reference_bundles = explode(',', $reference_bundles);
    $this->blockFieldAllowsEntityReferences($field_name, $paragraph_type, $reference_bundles);
  }

  /**
   * @Then the :arg1 field on :arg2 paragraph should allow references to :arg3 content/vocabulary (terms)
   */
  public function paragraphCheckFieldAllowsEntityReferences($field_name, $paragraph_type, $reference_bundles) {
    $reference_bundles = explode(',', $reference_bundles);
    $this->paragraphFieldAllowsEntityReferences($field_name, $paragraph_type, $reference_bundles);
  }

  /**
   * @Then the :arg1 field on :arg2 paragraph should allow references to :arg3 paragraphs
   */
  public function paragraphCheckFieldAllowsParagraphReferences($field_name, $paragraph_type, $reference_bundles) {
    $reference_bundles = explode(',', $reference_bundles);
    $this->paragraphFieldAllowsEntityReferences($field_name, $paragraph_type, $reference_bundles);
  }

  /**
   * The $field_name on $node_type should allow refs to $reference_bundles.
   */
  public function nodeFieldAllowsEntityReferences($field_name, $node_type, array $reference_bundles) {
    foreach ($reference_bundles as $reference_bundle) {
      $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions('node', $node_type);
      $field_definition = $bundle_fields[$field_name];
      $settings = $field_definition->getSettings();
      $target_bundles = $settings['handler_settings']['target_bundles'];
      Assert::assertContains(trim($reference_bundle), $target_bundles, $field_name . ' does not allow references to ' . trim($reference_bundle) . ' content');
    }
  }

  /**
   * The $field_name on $block_type should allow refs to $reference_bundles.
   */
  public function blockFieldAllowsEntityReferences($field_name, $block_type, array $reference_bundles) {
    foreach ($reference_bundles as $reference_bundle) {
      $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions('block_content', $block_type);
      $field_definition = $bundle_fields[$field_name];
      $settings = $field_definition->getSettings();
      $target_bundles = $settings['handler_settings']['target_bundles'];
      Assert::assertContains(trim($reference_bundle), $target_bundles, $field_name . ' does not allow references to ' . trim($reference_bundle) . ' blocks');
    }
  }

  /**
   * The $field_name on $paragraph_type should allow refs to $reference_bundles.
   */
  public function paragraphFieldAllowsEntityReferences($field_name, $paragraph_type, array $reference_bundles) {
    foreach ($reference_bundles as $reference_bundle) {
      $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions('paragraph', $paragraph_type);
      $field_definition = $bundle_fields[$field_name];
      $settings = $field_definition->getSettings();
      $target_bundles = $settings['handler_settings']['target_bundles'];
      Assert::assertContains(trim($reference_bundle), $target_bundles, $field_name . ' does not allow references to ' . trim($reference_bundle));
    }
  }

  /**
   * @Given the following roles have these permissions:
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
   */
  public function roleUserPermissionsNot(TableNode $rolesTable) {
    foreach ($rolesTable as $rolePermission) {
      $role = $rolePermission['role'];
      $permission = $rolePermission['permission'];
      $this->roleDoesNotHavePermission($role, $permission);
    }
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
   * @Then the :arg1 on the :arg2 display for :arg3 content is visible
   */
  public function nodeFieldVisibile($field_name, $display, $node_type) {
    $storage = \Drupal::entityTypeManager()->getStorage('entity_view_display');
    $view_display = $storage->load("node.$node_type.$display");
    $component = $view_display->getComponent($field_name);
    Assert::assertContains('content', $component['region']);
  }

  /**
   * @Then the :arg1 on the :arg2 display for :arg3 content is not visible
   */
  public function nodeFieldNotVisibile($field_name, $display, $node_type) {
    $storage = \Drupal::entityTypeManager()->getStorage('entity_view_display');
    $view_display = $storage->load("node.$node_type.$display");
    $component = $view_display->get('hidden');
    Assert::assertEquals(true, $component[$field_name]);
  }

  /**
   * @Then the :arg1 field has a limit of :arg2 on the :arg3 content type
   */
  public function nodeFieldLengthLimit($field_name, $length, $node_type) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions('node', $node_type);
    $field_definition = $bundle_fields[$field_name];
    $settings = $field_definition->getSettings();
    Assert::assertEquals($length, $settings['max_length']);
  }

  /**
   * @Then the field :arg1 is present on the :arg2 paragraph
   */
  public function isParagraphField($field_name, $paragraph_type) {
    $this->isField($field_name, 'paragraph', $paragraph_type);
  }

  /**
   * @Then the field :arg1 is present for the :arg2 block type
   */
  public function isBlockField($field_name, $block_type) {
    $this->isField($field_name, 'block_content', $block_type);
  }

  /**
   * @Then the :arg1 field is required for :arg2 content
   */
  public function nodeisRequiredField($field_name, $node_type) {
    $this->isRequiredField($field_name, 'node', $node_type);
  }

  /**
   * @Then the field :arg1 is required for the :arg2 paragraph
   */
  public function paragraphIsRequiredField($field_name, $paragraph_type) {
    $this->isRequiredField($field_name, 'paragraph', $paragraph_type);
  }

  /**
   * @Then the field :arg1 is required for the :arg2 block type
   */
  public function blockIsRequiredField($field_name, $paragraph_type) {
    $this->isRequiredField($field_name, 'block_content', $paragraph_type);
  }

  /**
   * The $field_name field is required for $node_type.
   */
  public function isRequiredField($field_name, $bundle, $node_type) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions($bundle, $node_type);
    $field_definition = $bundle_fields[$field_name];
    $setting = $field_definition->isRequired();
    Assert::assertNotEmpty($setting, 'Field ' . $field_name . ' is not required.');
  }

  /**
   * @Given that only the following roles have content permissions for the :arg1 content type:
   */
  public function roleOnlyContentPermissions($node_type, TableNode $rolesTable) {
    $allowed_roles = array();
    foreach ($rolesTable as $rolePermission) {
      $role = $rolePermission['role'];
      $permission = $rolePermission['permission'] . ' ' . $node_type . ' content';
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
   * Get all user roles.
   */
  public function getRoles() {
    $roles = user_roles();
    $roles = array_keys($roles);
    return $roles;
  }

  /**
   * @Given :arg1 has permission to use the following transition states
   */
  public function roleRevisionTransisions($role, TableNode $transitionTable) {
    foreach ($transitionTable as $transitionPermission) {
      $state = $transitionPermission['transition'];
      $permission = 'use ' . $state . ' transition';
      $this->roleHasPermission($role, $permission);
    }
  }

  /**
   * @Given :arg1 does not have permission to use the following transition states
   */
  public function roleNegativeTransisions($role, TableNode $transitionTable) {
    foreach ($transitionTable as $transitionPermission) {
      $state = $transitionPermission['transition'];
      $permission = 'use ' . $state . ' transition';
      $this->roleDoesNotHavePermission($role, $permission);
    }
  }

  /**
   * @Given the following content types use workbench moderation:
   */
  public function contentTypeModeration(TableNode $contentTypesTable) {
    foreach ($contentTypesTable as $contentTypeRow) {
      if (!$this->contentTypeUsesModeration($contentTypeRow['content type'])) {
        throw new \Exception('Content type ' . $contentTypeRow['content type'] . ' does not use workbench moderation.');
      }
    }
  }

  /**
   * Checks content type config entity to see if workbench moderation is enabled.
   *
   * @param $content_type
   *
   * @return bool|mixed|null
   */
  private function contentTypeUsesModeration($content_type) {
    if (!($info = NodeType::load($content_type))) {
      return FALSE;
    }

    return $info->getThirdPartySetting('workbench_moderation', 'enabled');
  }
}
