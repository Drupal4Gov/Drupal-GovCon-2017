<?php

namespace Drupal\capitalcamp_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides Secondary Hero Block.
 *
 * @Block(
 *   id = "dgc_secondary_hero",
 *   admin_label = @Translation("DGC Secondary Page Hero")
 * )
 */
class DgcSecondaryHero extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#type' => 'markup',
      '#markup' => '',
    ];
  }

}
