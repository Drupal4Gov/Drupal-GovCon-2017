Feature: User Registration
  As an anonymous user
  I want to register for an account
  So that I can fully utilize the GovCon Website

  Scenario: Access Registration Form
    Given I am on "/user/register"
    Then I should see the text "Create new account"
  @javascript
  Scenario: Required Fields on Registration Form
    Given I am on "/user/register"
    Then I should see a "#edit-account" element
    And I should see a "#edit-field-first-name-wrapper" element
    And I should see a "#edit-field-last-name-wrapper" element
    And I should see a "#edit-field-company-organization-wrapper" element