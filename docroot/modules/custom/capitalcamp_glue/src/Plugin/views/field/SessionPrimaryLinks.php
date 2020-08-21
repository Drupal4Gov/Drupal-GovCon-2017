<?php

namespace Drupal\capitalcamp_glue\Plugin\views\field;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Session\AccountProxy;
use Drupal\taxonomy\Entity\Term;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\capitalcamp_blocks\Plugin\views\access\SessionAccess;

/**
 * Field handler for custom access on session links.
 *
 * @ViewsField("session_primary_links")
 */
class SessionPrimaryLinks extends FieldPluginBase {

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
    $access = SessionAccess::determineAccess($this->account, $webformStorage);
    if ($access == TRUE) {
      $node = $values->_entity;
      $room = $node->get("field_room")->getValue();
      if (isset($room[0]['target_id'])) {
        $term = Term::load($room[0]['target_id']);
        return $this->convertUrl($term->get("field_primary_video_link")->getValue());
      }
    }

    return FALSE;
  }

  /**
   * Function to convert a URI to a renderable Link.
   *
   * @param array $field
   *   The field from the node.
   *
   * @return object|bool
   *   Returns FALSE if no URI on the field or a renderable link.
   */
  public static function convertUrl(array $field) {
    if (!isset($field[0]['uri'])) {
      return FALSE;
    }
    return Link::fromTextAndUrl($field[0]['title'], Url::fromUri($field[0]['uri']))->toRenderable();
  }

}
