<?php

namespace Drupal\capitalcamp_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides Secondary banners Block.
 *
 * @Block(
 *   id = "dgc_secondarybanners",
 *   admin_label = @Translation("DGC Secondary banners")
 * )
 */
class DgcSecondarybanners extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#type' => 'markup',
      '#markup' => 'hi',
    ];
  }

}
