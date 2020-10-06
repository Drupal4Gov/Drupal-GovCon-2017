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
 * Provides a DGC Proposed Sessions block.
 *
 * @Block(
 *   id = "dgc_proposed_sessions",
 *   admin_label = @Translation("DGC Proposed Sessions")
 * )
 */
class DgcProposedSessions extends BlockBase implements ContainerFactoryPluginInterface {

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

    // Conference Year Settings.
    $conferenceYearVocabularyId = 'conference_year';
    $conferenceYearTerms = $this->termStorage->loadTree($conferenceYearVocabularyId);
    $this->conferenceYearTermsOptions = [];
    foreach ($conferenceYearTerms as $conferenceYearTerm) {
      $this->conferenceYearTermsOptions[$conferenceYearTerm->tid] = $conferenceYearTerm->name;
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
      $container->get('entity_type.manager')->getStorage('view'),
      $container->get('views.executable')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'sponsorship_year_term' => '1',
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
    $form['conference_year_term'] = [
      '#type' => 'select',
      '#title' => $this->t("Conference Year"),
      '#default_value' => $this->configuration['conference_year_term'],
      '#options' => $this->conferenceYearTermsOptions,
      '#description' => $this->t('Select the conference year you would like to display.'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['conference_year_term'] = $form_state->getValue('conference_year_term');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $content = [];
    $view = $this->viewEntityStorage->load('session_status_blocks');
    $viewExecutable = $this->viewExecutableFactory->get($view);
    $viewDisplayId = 'block_1';
    if ($viewExecutable) {
      $viewExecutable->setArguments([
        'field_conference_year' => $this->configuration['conference_year_term'],
      ]);
      $viewExecutable->setDisplay($viewDisplayId);
      $viewExecutable->preExecute();
      $viewExecutable->execute();
      $content['proposed_sessions'] = $viewExecutable->buildRenderable(
        $viewDisplayId,
        [
          'field_conference_year' => $this->configuration['conference_year_term'],
        ],
        FALSE);
    }

    return [
      "#theme" => 'dgc_proposed_sessions',
      '#proposed_sessions' => $content['proposed_sessions'],
      '#conference_year' => $this->termStorage->load($this->configuration['conference_year_term'])->label(),
    ];
  }

}
