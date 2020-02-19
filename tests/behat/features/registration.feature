@api
Feature: Registration Tests
  Scenario: Ensure Form Cannot Be Accessed Anonymously
    Given I am on "/register"
    Then I should see "Log in"
    And I should not see "2020 Registration"

  Scenario: Ensure Form Can Be Accessed when Authenticated
    Given I am logged in as a user with the "authenticated" role
    And I am on "/register"
    Then I should see "2020 Registration"

  Scenario: Ensure Form Fields
    Given I am logged in as a user with the "authenticated" role
    And I am on "/register"
    Then I should see "Attendee Email"
    Then I should see "First Name"
    Then I should see "Last Name"
    Then I should see "Drupal.org User Name"
    Then I should see "Twitter Handle"
    Then I should see "Country"
    Then I should see "Is this your first time attending Drupal GovCon?"
    Then I should see "Are you attending Sprints?"
    Then I should see "How did you hear about Drupal GovCon?"
    Then I should see "Sign me up for Drupal GovCon news"
    Then I should see "Sign me up for Drupal4Gov infrequent educational / training news"
    Then I should see "Sign me up for infrequent sponsor news and promotions"
    Then I should see "No thanks, I'm subscribed already or get my Drupal news elsewhere"
    Then I should see "Company Name"
    Then I should see "HOW WOULD YOU DESCRIBE YOUR COMPANY?"
    Then I should see "PLEASE SELECT THE INDUSTRIES THAT YOU WORK IN (SELECT ALL THAT APPLY)"
    Then I should see "HOW DO YOU USE DRUPAL?"
    Then I should see "What is your level of Drupal experience?"
    Then I should see "WHAT IS YOUR ROLE AT YOUR ORGANIZATION?"
    Then I should see "IN MY ORGANIZATION, I HAVE INPUT ON THE PURCHASE OF THE FOLLOWING:"
    Then I should see "Contact me closer to the event regarding on-site volunteer opportunities."
    Then I should see "Please contact me to discuss my specific on-site accessibility needs."
    Then I should see "Yes, I have read and will adhere to the Drupal GovCon Code of Conduct and Media Policy"
    And I should not see "We are at capacity."
    And I should not see "Please indicate the days when you'll need lunch."
    And I should not see "Wait List"
