@api
Feature: User Registration and Management Settings and Access
  Scenario: User profile has necessary field settings.
    Given the field "field_first_name" is present for users
    And the field "field_last_name" is present for users
    And the field "field_job_title" is present for users
    And the field "field_twitter_account" is present for users
    And the field "field_website" is present for users
    And the "field_first_name" field should be required for users
    And the "field_last_name" field should be required for users
