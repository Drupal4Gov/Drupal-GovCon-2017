<?php

namespace Drupal\capitalcamp_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a DGC ASessionize Block.
 *
 * @Block(
 *   id = "dgc_sessionize",
 *   admin_label = @Translation("DGC Sessionize Embed")
 * )
 */
class DgcSessionize extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      "#theme" => 'dgc_sessionize',
    ];
  }

}
