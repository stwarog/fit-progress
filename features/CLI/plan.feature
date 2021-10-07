Feature:
  In order to prove a plan CLI works
  I can pass arguments to CLI.

  The mandatory arguments are:
  - name

  Extra fields are:
  - exercises (collection of activities to train)

  Scenario: Create plan with name
    Given   a plan named "Plan for reduction"
    When    command app:plan:create is executed
    Then    new plan should be created with name "Plan for reduction"

  Scenario: Create a plan with exercises in
    Given   a plan named "Plan for reduction 2"
    And     exercises are set to
      | weight | repeats | exercise                             |
      | 20     | 10      | 4ef022ee-bd51-405e-b1a6-e23139a3e9d3 |
      | 30     | 8       | 4ef022ee-bd51-405e-b1a6-e23139a3e9d3 |
      | 40     | 6       | 4ef022ee-bd51-405e-b1a6-e23139a3e9d3 |
    When    command app:plan:create is executed
    Then    new plan should be created with name "Plan for reduction 2"
    And     plan exercises should be added
      | weight | repeats | exercise                             |
      | 20     | 10      | 4ef022ee-bd51-405e-b1a6-e23139a3e9d3 |
      | 30     | 8       | 4ef022ee-bd51-405e-b1a6-e23139a3e9d3 |
      | 40     | 6       | 4ef022ee-bd51-405e-b1a6-e23139a3e9d3 |

  @fail
  Scenario: Create plan without mandatory fields
    Given   a plan without name
    When    command app:plan:create is executed
    Then    no plan should be created
