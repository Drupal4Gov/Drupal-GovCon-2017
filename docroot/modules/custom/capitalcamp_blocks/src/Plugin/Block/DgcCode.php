<?php

namespace Drupal\capitalcamp_blocks\Plugin\Block;

use Drupal\capitalcamp_blocks\Plugin\views\access\SessionAccess;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Configurable Code.
 *
 * @Block(
 *   id = "dgc_code_block",
 *   admin_label = @Translation("DGC Registration Code")
 * )
 */
class DgcCode extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The Entity Type Manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * The Account.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $account;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManager $entity_type_manager, AccountProxy $account) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->account = $account;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'dgc_registration_code' => NULL,
    ];
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
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $form['dgc_registration_code'] = [
      '#type' => 'textarea',
      '#title' => $this->t("Registration Code / Text"),
      '#default_value' => $this->configuration['dgc_registration_code'],
      '#description' => $this->t('This text will be displayed in the block.'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $this->configuration['dgc_registration_code'] = $form_state->getValue('dgc_registration_code');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $webformStorage = $this->entityTypeManager->getStorage("webform_submission");
    if (SessionAccess::determineAccess($this->account, $webformStorage) == TRUE) {
      return [
        '#theme' => "dgc_registration_code",
        '#plain_text' => $this->configuration['dgc_registration_code'] ?? NULL,
      ];
    }
    return [];
  }

}
