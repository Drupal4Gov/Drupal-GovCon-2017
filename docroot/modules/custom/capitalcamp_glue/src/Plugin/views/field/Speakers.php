<?php

namespace Drupal\capitalcamp_glue\Plugin\views\field;

use Drupal\Core\Link;
use Drupal\user\Entity\User;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Field handler to flag the node type.
 *
 * @ViewsField("speakers")
 */
class Speakers extends FieldPluginBase {

  /**
   * Leave empty to avoid a query on this field.
   */
  public function query() {

  }

  /**
   * Render function for the speakers field.
   *
   * Displays usernames for both node author and co-speakers field(s).
   *
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {
    $presenters = [];
    $names = NULL;
    $options = [
      'absolute' => TRUE,
      'attributes' => [
        'class' => "views-field-uid",
      ],
    ];
    /** @var \Drupal\node\Entity\Node $node */
    $node = $values->_entity;

    // Primary Speaker (is node Author).
    $uid = $node->get("uid")->getString();
    $user = User::load($uid);
    $presenters[] = Link::createFromRoute($user->name->value, 'entity.user.canonical', ['user' => $uid], $options)->toString();

    // Co-speakers.
    if ($node->hasField("field_session_co_presenter_s_")) {
      $co = $node->get('field_session_co_presenter_s_')->referencedEntities();
      if ($co) {
        foreach ($co as $speaker) {
          $presenters[] = Link::createFromRoute($speaker->name->value, 'entity.user.canonical', ['user' => $speaker->uid->value], $options)->toString();
        }
      }
    }

    for ($i = 0; $i < count($presenters) - 1; $i++) {
      $names .= $presenters[$i] . ", ";
    }
    $names .= $presenters[count($presenters) - 1];

    return [
      '#markup' => $names,
    ];
  }

}
