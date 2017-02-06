<?php

namespace Drupal\capitalcamp_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\Core\Menu\MenuTreeParameters;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a DGC Nav Block.
 *
 * @Block(
 *  id = "dgc_nav",
 *  admin_label = @Translation("DGC Nav"),
 * )
 */
class DgcNav extends BlockBase implements ContainerFactoryPluginInterface
{

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MenuLinkTreeInterface $menu_tree)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->menuTree = $menu_tree;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('menu.link_tree')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $parameters = new MenuTreeParameters();
    $tree = $this->menuTree->load('main', $parameters);
    $processedFooter = [];

    // Normalize the menu so that we don't need to in twig.
    foreach ($tree as $treeElement) {
      $currentParsedRecord = [];
      $currentParsedRecord['text'] = $treeElement->link->getTitle();
      $currentParsedRecord['url'] = $treeElement->link->getUrlObject();
      $processedFooter[] = $currentParsedRecord;
    }

    $build['nav_links'] = $processedFooter;
    return $build;
  }

}
