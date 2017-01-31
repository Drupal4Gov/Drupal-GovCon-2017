<?php

namespace Drupal\capitalcamp_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides Hero Block.
 *
 * @Block(
 *   id = "dgc_hero",
 *   admin_label = @Translation("DGC Hero")
 * )
 */
class DgcHero extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#type' => 'markup',
      '#markup' => '',
    );
  }

}
