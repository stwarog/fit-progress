Feature:
    In order to prove a training CLI works
    I can pass arguments to CLI.

    The mandatory arguments are:
    - name

    Extra fields are:
    - date (if not passed, current date should be used)
    - plan

    Scenario: Create training with name
      Given   a Training named "Full body work out"
      When    command is executed
      Then    new Training should be created with name "Full body work out" and current date

  Scenario: Create training with name and date
    Given   a Training named "Full body work out 2"
    And     date "2020-01-01" is set
    When    command is executed
    Then    new Training should be created with name "Full body work out 2" and date should "2020-01-01"

  Scenario: Create training with name, date and plan
    Given   a Training named "Full body work out 3"
    And     an existing Plan with id "4ef022ee-bd51-405e-b1a6-1234123"
    And     date "2020-01-05" is set
    And     plan "4ef022ee-bd51-405e-b1a6-1234123" is set
    When    command is executed
    Then    new Training should be created with name "Full body work out 3" and date should "2020-01-05" and plan "4ef022ee-bd51-405e-b1a6-1234123"

  @fail
  Scenario: Create training without mandatory fields
    Given   a Training without name
    When    command is executed
    Then    no training should be created
