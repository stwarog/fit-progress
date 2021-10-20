Feature:
  In order to prove a training list CLI works

  Listing a training should give me a information:
  - training status (planned, started, ended, skipped)
  - type (free - no plan assigned, planned)
  - date
  - progress activities * repeats / planned exercises * repeats

  Background: Existing plans
    Given predefined plans
      | id                                   | name           | exercises                                                                                                                         |
      | planId                               | planId         | 100,8,4ef022ee-bd51-405e-b1a6-e23139a3e9d3 120,5,4ef022ee-bd51-405e-b1a6-e23139a3e9d3 150,12,4ef022ee-bd51-405e-b1a6-e23139a3e9d3 |
      | 569c3f90-987f-459d-ae50-37f6d1a707d3 | Full body plan | 20,15,6eac986a-debe-4e08-8989-7b4fdd94cbf0 25,20,a7041851-d794-4153-a337-db468eefd7b5                                             |

    And trainings that has been made
      | id                                   | plan                                 | name                         | date       |
      | 91c71952-71c8-4a12-9168-7c5cac8d4711 |                                      | Training with no plan        | 2021-10-10 |
      | trainingId                           | planId                               | Full body plan               | 2021-02-27 |
      | d528cf56-dd82-4dfe-89c1-a535c9699a7d | 569c3f90-987f-459d-ae50-37f6d1a707d3 | Full body plan (not started) | 2021-02-02 |

  Scenario: List all trainings
    When command app:training:list is executed
    Then a list with values should be displayed
      """
      +--------------------------------------+------------------------------+---------+------------+--------------------------------------+-----------------+-------------+----------------+---------------+------------------+--------------+
      | id                                   | name                         | status  | date       | planId                               | planName        | doneRepeats | plannedRepeats | doneExercises | plannedExercises | liftedWeight |
      +--------------------------------------+------------------------------+---------+------------+--------------------------------------+-----------------+-------------+----------------+---------------+------------------+--------------+
      | 91c71952-71c8-4a12-9168-7c5cac8d4711 | Training with no plan        | planned | 2021-10-10 |                                      |                 | 0           | 0              | 0             | 0                | 0            |
      | trainingId                           | Full body plan               | planned | 2021-02-27 | planId                               | planId          | 0           | 3              | 0             | 3                | 0            |
      | d528cf56-dd82-4dfe-89c1-a535c9699a7d | Full body plan (not started) | planned | 2021-02-02 | 569c3f90-987f-459d-ae50-37f6d1a707d3 | Full body plan  | 0           | 2              | 0             | 2                | 0            |
      +--------------------------------------+------------------------------+---------+------------+--------------------------------------+-----------------+-------------+----------------+---------------+------------------+--------------+
      """

  Scenario: Add activity increases values
    When command app:activity:add is executed
      | training   | weight | repeats | exercise                             |
      | trainingId | 150    | 2       | 4ef022ee-bd51-405e-b1a6-e23139a3e9d3 |
    And command app:training:list is executed
    Then a list with values should be displayed
      """
      +--------------------------------------+------------------------------+---------+------------+--------------------------------------+-----------------+-------------+----------------+---------------+------------------+--------------+
      | id                                   | name                         | status  | date       | planId                               | planName        | doneRepeats | plannedRepeats | doneExercises | plannedExercises | liftedWeight |
      +--------------------------------------+------------------------------+---------+------------+--------------------------------------+-----------------+-------------+----------------+---------------+------------------+--------------+
      | 91c71952-71c8-4a12-9168-7c5cac8d4711 | Training with no plan        | planned | 2021-10-10 |                                      |                 | 0           | 0              | 0             | 0                | 0            |
      | trainingId                           | Full body plan               | started | 2021-02-27 | planId                               | planId          | 2           | 3              | 1             | 3                | 300          |
      | d528cf56-dd82-4dfe-89c1-a535c9699a7d | Full body plan (not started) | planned | 2021-02-02 | 569c3f90-987f-459d-ae50-37f6d1a707d3 | Full body plan  | 0           | 2              | 0             | 2                | 0            |
      +--------------------------------------+------------------------------+---------+------------+--------------------------------------+-----------------+-------------+----------------+---------------+------------------+--------------+
      """

