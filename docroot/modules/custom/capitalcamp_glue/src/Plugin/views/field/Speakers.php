<?php

namespace Drupal\capitalcamp_glue\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\user\Entity\User;

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
    /** @var \Drupal\node\Entity\Node $node */
    $node = $values->_entity;

    // Primary Speaker (is node Author).
    $uid = $node->get("uid")->getString();
    $user = User::load($uid);
    $presenters[] = $user->name->value;

    // Co-speakers.
    $co = $node->get('field_session_co_presenter_s_')->referencedEntities();
    if ($co) {
      foreach ($co as $speaker) {
        $presenters[] = $speaker->name->value;
      }
    }

    for ($i = 0; $i < count($presenters) - 1; $i++) {
      $names .= $presenters[$i] . ", ";
    }
    $names .= $presenters[count($presenters) - 1];
    return $names;
  }

}
