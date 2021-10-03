Feature:
  In order to prove a training activity CLI works
  I can pass arguments to CLI.

  The mandatory arguments are:
  - training
  - weight
  - repeats
  - exercise

  Background:
    Given     there is an existing training "a7041851-d794-4153-a337-db468eefd7b5"
    And       there is an existing exercise "4ef022ee-bd51-405e-b1a6-e23139a3e9d3" in the catalog

  Scenario: Create activity with valid training and exercise
    Given   Activity with training "a7041851-d794-4153-a337-db468eefd7b5"
    And     and Exercise "4ef022ee-bd51-405e-b1a6-e23139a3e9d3" from the catalog
    And     weight "20" is set
    And     repeats "10" are set
    When    command app:activity:add is executed
    Then    new Activity should be added
      | training                             | weight | repeats | exercise                             |
      | a7041851-d794-4153-a337-db468eefd7b5 | 20     | 10      | 4ef022ee-bd51-405e-b1a6-e23139a3e9d3 |

  @fail
  Scenario: Add Activity without mandatory fields
    Given   an Activity without fields
    When    command app:activity:add is executed
    Then    no Activity should be created
