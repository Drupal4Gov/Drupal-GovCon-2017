@api
Feature: Session Tests
  Background: Content Creation
    Given "session" content:
      | title                 | body                    | status | moderation_state | field_conference_year | field_status | field_experience_level | field_session_track | field_i_can_deliver_this_session |
      | Proposed Session Node | Content for a session   | 1      | published        | 2020                  | proposed     | Beginner               | Backend             | Virtual Only                     |
      | Accepted Session Node | Content for a session   | 1      | published        | 2020                  | accepted     | Beginner               | Backend             | Virtual Only                     |
      | Old Session Node      | Content for a session   | 1      | published        | 2019                  | accepted     | Beginner               | Backend             | Virtual Only                     |
    Given users:
      | name     | mail        | field_first_name | field_last_name |
      | admin    |no-reply@acquia.com| test | user                |

  #Scenario: Proposed Session View
    #Given I am on "/2020/program/proposed-sessions"
    #Then I should see "Proposed Session Node"
    #And I should see "Accepted Session Node"
    #And I should not see "Old Session Node"

  #Scenario: Accepted Session View
    #Given I am on "/2020/program/sessions"
    #Then I should see "Accepted Session Node"
    #And I should not see "Proposed Session Node"
    #And I should not see "Old Session Node"

  Scenario: Confirm Session Links Hidden for Anon
    Given I am on "/2020/program/sessions/automated-accessibility-testing-using-pa11y-and-continuous-integration"
    Then I should not see "Primary Video Link"
    And I should not see "Alternate Video Link"
    And I am on "/2020/schedule/09/24"
    Then I should not see "Primary Video Link"
    And I should not see "Alternate Video Link"

