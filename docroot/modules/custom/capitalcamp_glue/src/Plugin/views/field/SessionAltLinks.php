<?php

namespace Drupal\capitalcamp_glue\Plugin\views\field;

use Drupal\capitalcamp_blocks\Plugin\views\access\SessionAccess;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Session\AccountProxy;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Field handler for custom access on session links.
 *
 * @ViewsField("session_alt_links")
 */
class SessionAltLinks extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManager $entity_type_manager, AccountProxy $account) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->account = $account;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('current_user')
    );
  }

  /**
   * Leave empty to avoid a query on this field.
   */
  public function query() {

  }

  /**
   * Render function for the attendee_name field.
   *
   * Displays a full name based on the webform's first and last name
   * that is then linked to the related user's profile.
   *
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {
    $webformStorage = $this->entityTypeManager->getStorage("webform_submission");
    $node = $values->_entity;
    $access = SessionAccess::determineAccess($this->account, $webformStorage);
    if ($access == TRUE) {
      return SessionPrimaryLinks::convertUrl($node->get("field_alternate_video_link")->getValue(), "Alternate Link");
    }
    return FALSE;
  }

}
