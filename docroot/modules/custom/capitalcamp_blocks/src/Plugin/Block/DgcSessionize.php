<?php

namespace Drupal\capitalcamp_blocks\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a DGC ASessionize Block.
 *
 * @Block(
 *   id = "dgc_sessionize",
 *   admin_label = @Translation("DGC Sessionize Embed")
 * )
 */
class DgcSessionize extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'path' => NULL,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['path'] = [
      '#type' => 'textarea',
      '#title' => $this->t("Sessionize Path"),
      '#default_value' => $this->configuration['path'],
      '#description' => $this->t('This block will automatically embed Sessionize scripts. Add anything in the URL beyond the ""https://sessionize.com/api/v2/"'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['path'] = $form_state->getValue('path');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      "#theme" => 'dgc_sessionize',
      '#base_url' => 'https://sessionize.com/api/v2/',
      '#path' => $this->configuration['path'],
    ];
  }

}
