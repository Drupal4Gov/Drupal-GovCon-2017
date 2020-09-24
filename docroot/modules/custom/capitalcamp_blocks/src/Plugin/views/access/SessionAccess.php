<?php

namespace Drupal\capitalcamp_blocks\Plugin\views\access;

use Drupal\views\Plugin\views\access\AccessPluginBase;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\webform\WebformSubmissionStorage;

/**
 * Class SessionAccess provides an access check to 2020 sessions.
 *
 * @ingroup views_access_plugins
 *
 * @ViewsAccess(
 *     id = "SessionAccess",
 *     title = @Translation("Attendee Access Handler"),
 *     help = @Translation("Add custom logic to access() method"),
 * )
 */
class SessionAccess extends AccessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManager $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function summaryTitle() {
    return $this->t('Attendee Access Handler');
  }

  /**
   * {@inheritdoc}
   */
  public function access(AccountInterface $account) {
    $webformStorage = $this->entityTypeManager->getStorage("webform_submission");
    return $this->determineAccess($account, $webformStorage);
  }

  /**
   * {@inheritdoc}
   */
  public function alterRouteDefinition(Route $route) {
    $route->setRequirement('_access', 'TRUE');
  }

  /**
   * Function to determine if current user has a valid ticket.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Account object.
   * @param \Drupal\webform\WebformSubmissionStorage $webformStorage
   *   Webfpr, storage object.
   *
   * @return bool
   *   Returns true / false based on ticket status.
   */
  public static function determineAccess(AccountInterface $account, WebformSubmissionStorage $webformStorage) {
    if ($account->isAuthenticated()) {
      $roles = $account->getRoles();
      if (in_array("administrator", $roles) || in_array("volunteer", $roles)) {
        return TRUE;
      }
      // Find this user's webform(s), if present.
      $wids = $webformStorage->getQuery()
        ->condition('webform_id', '2020_registration')
        ->condition('uid', $account->id())
        ->execute();
      $webforms = $webformStorage->loadMultiple($wids);
      // Confirms that at least one webform was found for the current user.
      if (count($webforms) > 0) {
        foreach ($webforms as $webform) {
          // Access webform data.
          $results = $webform->getData();
          // Confirm that this webform is for the current user
          // and not registered by this user for another person.
          if ($results['email'] == $account->getEmail()) {
            // Confirm they have an actual ticket.
            if ($results['ticket_status'] == "Ticket") {
              // Grant access to the view.
              return TRUE;
            }
          }
        }
      }
    }
    // Grant no access to the view if the user doesn't have a valid ticket.
    return FALSE;
  }

}
