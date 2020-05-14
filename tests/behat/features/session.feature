@api
Feature: Session Tests
  Background: Content Creation
    Given "session" content:
      | title                 | body                    | status | moderation_state | field_conference_year | field_status | field_experience_level | field_session_track | field_i_can_deliver_this_session |
      | Proposed Session Node | Content for a session   | 1      | published        | 2020                  | proposed     | Beginner               | Keynote             | Virtual Only                     |
      | Accepted Session Node | Content for a session   | 1      | published        | 2020                  | accepted     | Beginner               | Keynote             | Virtual Only                     |
      | Old Session Node      | Content for a session   | 1      | published        | 2019                  | accepted     | Beginner               | Keynote             | Virtual Only                     |

  Scenario: Ensure Form Fields
    Given I am logged in as a user with the "authenticated" role
    And I am on "/node/add/session"
    Then I should see "Session Title"
    And I should see "I can deliver this session"
    And I should see "Session Track"
    And I should see "Experience Level"
    And I should see "Session Description"
    And I should see "Co-Presenter(s)"
    And I should not see "Status"
    And I should not see "Conference Year"
    And I should not see "Room Monitor"
    And I should not see "Male Attendees"
    And I should not see "Female Attendees"

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

  Scenario: Admin Proposed Session View
    Given I am logged in as a user with the "administrator" role
    And I am on "/admin/sessions/proposed?field_conference_year_target_id=296&field_status_value=All&field_session_track_target_id=All&title=&combine="
    Then I should see "Proposed Session Node"
    And I should see "Accepted Session Node"
    And I should not see "Old Session Node"
