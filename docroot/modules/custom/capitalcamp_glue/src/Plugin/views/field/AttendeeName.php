<?php

namespace Drupal\capitalcamp_glue\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\Core\Link;


/**
 * Field handler to flag the node type.
 *
 * @ViewsField("attendee_name")
 */
class AttendeeName extends FieldPluginBase {

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
    /** @var \Drupal\webform\Entity\WebformSubmission $webform */
    $webform = $values->_entity;
    $email = $webform->getElementData('email');
    $firstName = strtolower($webform->getElementData('first_name'));
    $lastName = strtolower($webform->getElementData('last_name'));
    $name = NULL;
    if ($firstName && $lastName) {
      $name = ucwords("$firstName $lastName");
    }
    if ($email) {
      /** @var \Drupal\user\Entity\User $user */
      $user = user_load_by_mail($email);
      if ($user) {
        $link =  Link::createFromRoute($name, 'entity.user.canonical', ['user' => $user->id()]);
        return $link->toRenderable();
      }
    }
    return $name;
  }

}
