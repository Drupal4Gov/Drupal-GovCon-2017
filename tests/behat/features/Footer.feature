@footer
Feature: Footer
  In order to verify that the footer is displayed
  As a user
  I should be able to see the footer on the homepage
  With and without Javascript

  @javascript
  Scenario: Load a page with Javascript
    Given I am on "/"
    And I should see the text "Drupal GovCon is graciously hosted by the NIH Library"

  Scenario: Load a page without Javascript
    Given I am on "/"
    Then I should see a "footer" element
    And I should see the text "Drupal GovCon is graciously hosted by the NIH Library"
