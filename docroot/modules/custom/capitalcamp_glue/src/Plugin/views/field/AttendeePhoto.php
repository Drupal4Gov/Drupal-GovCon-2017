<?php

namespace Drupal\capitalcamp_glue\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\file\Entity\File;
use Drupal\user\Entity\User;


/**
 * Field handler to flag the node type.
 *
 * @ViewsField("attendee_photo")
 */
class AttendeePhoto extends FieldPluginBase {

  /**
   * Leave empty to avoid a query on this field.
   */
  public function query() {

  }

  /**
   * Render function for the attendee_photo field.
   *
   * Displays a user profile photo.
   *
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {
    /** @var \Drupal\webform\Entity\WebformSubmission $webform */
    $webform = $values->_entity;
    $email = $webform->getElementData('email');
    if ($email) {
      /** @var \Drupal\user\Entity\User $user */
      $user = user_load_by_mail($email);
      if ($user) {
        $image = $user->get('field_picture')->getValue();
        if ($image[0]['target_id']) {
          $fid = $image[0]['target_id'];
          $file = File::load($fid);
          $render = [
            '#theme' => 'image_style',
            '#style_name' => 'thumbnail',
            '#uri' => $file->getFileUri(),
          ];
          return render($render);

        }
        else {
          $user = User::load(1);
          $image = $user->get('field_picture')->getValue();
          $fid = $image[0]['target_id'];
          $file = File::load($fid);
          $render = [
            '#theme' => 'image_style',
            '#style_name' => 'thumbnail',
            '#uri' => $file->getFileUri(),
          ];
          return render($render);
        }
      }
    }
  }

}
