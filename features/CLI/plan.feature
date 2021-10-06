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

  @fail
  Scenario: Create plan without mandatory fields
    Given   a plan without name
    When    command app:plan:create is executed
    Then    no plan should be created
