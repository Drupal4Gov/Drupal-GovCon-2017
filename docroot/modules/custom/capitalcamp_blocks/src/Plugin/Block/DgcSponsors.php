<?php

namespace Drupal\capitalcamp_blocks\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\taxonomy\TermStorageInterface;
use Drupal\views\ViewExecutableFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a DGC Sponsors by Level block.
 *
 * @Block(
 *   id = "dgc_sponsors_by_level",
 *   admin_label = @Translation("DGC Sponsors by Level")
 * )
 */
class DgcSponsors extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Term storage.
   *
   * @var \Drupal\taxonomy\TermStorageInterface
   */
  protected $termStorage;

  /**
   * The entity storage for views.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $viewEntityStorage;

  /**
   * The factory to load a view executable with.
   *
   * @var \Drupal\views\ViewExecutableFactory
   */
  protected $viewExecutableFactory;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, TermStorageInterface $termStorage, EntityStorageInterface $viewEntityStorage, ViewExecutableFactory $viewExecutableFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->termStorage = $termStorage;
    $this->viewEntityStorage = $viewEntityStorage;
    $this->viewExecutableFactory = $viewExecutableFactory;

    // Sponsors by Level Settings.
    $sponsorshipLevelVocabularyId = 'sponsorship_level';
    $sponsorshipLevelTerms = $this->termStorage->loadTree($sponsorshipLevelVocabularyId);
    $this->sponsorshipLevelTermOptions = array();
    foreach ($sponsorshipLevelTerms as $sponsorshipLevelTerm) {
      $this->sponsorshipLevelTermOptions[$sponsorshipLevelTerm->tid] = $sponsorshipLevelTerm->name;
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')->getStorage('taxonomy_term'),
      $container->get('entity.manager')->getStorage('view'),
      $container->get('views.executable')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'sponsorship_level_term' => '1',
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
  public function blockForm($form, FormStateInterface $form_state) {
    $form['sponsors_block_sponsorship_level_term'] = array(
      '#type' => 'select',
      '#title' => $this->t("Sponsorship Level"),
      '#default_value' => $this->configuration['sponsorship_level_term'],
      '#options' => $this->sponsorshipLevelTermOptions,
      '#description' => $this->t('Select the sponsorship level you would like to display.'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['sponsorship_level_term'] = $form_state->getValue('sponsors_block_sponsorship_level_term');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $content = [];
    $termId = $this->configuration['sponsorship_level_term'];
    $args = [$termId];
    $view = $this->viewEntityStorage->load('sponsors');
    $viewExecutable = $this->viewExecutableFactory->get($view);
    $viewDisplayId = 'block';
    if ($viewExecutable) {
      $viewExecutable->setArguments($args);
      $viewExecutable->setDisplay($viewDisplayId);
      $viewExecutable->preExecute();
      $viewExecutable->execute();
      $content['sponsor_listing'] = $viewExecutable->buildRenderable($viewDisplayId, $args, FALSE);
    }

    $content['sponsor_level'] = $this->sponsorshipLevelTermOptions[$termId];
    return $content;
  }

}
