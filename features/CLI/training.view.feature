Feature:
  In order to prove a training list CLI works

  Listing a training should give me a information:
  - training status (planned, started, ended, skipped)
  - type (free - no plan assigned, planned)
  - date
  - progress activities * repeats / planned exercises * repeats

  Rules:
  Super hard plan exercises
  | id                                   | weight         | repeats | exercise |
  | ee26d867-2048-48e9-a455-d6cf8013f9c4 | 100            | 8       | 4ef022ee-bd51-405e-b1a6-e23139a3e9d3 |
  | 40d9dec5-eb21-43fc-891d-58b349a4db91 | 120            | 5       | 4ef022ee-bd51-405e-b1a6-e23139a3e9d3 |
  | 2f059420-047a-464f-a606-4fa422c32e77 | 150            | 3       | 4ef022ee-bd51-405e-b1a6-e23139a3e9d3 |

  Background: Existing plans
    Given plans
      | id                                   | name            |
      | 013a149a-9839-45bf-b5c9-0fabef0c7747 | Super hard plan |
      | 569c3f90-987f-459d-ae50-37f6d1a707d3 | Full body plan  |

    And trainings
      | id                                   | plan                                 | name                         | 2021-10-11 |
      | 91c71952-71c8-4a12-9168-7c5cac8d4711 |                                      | Training with no plan        | 2021-10-10 |
      | 382424e9-6afa-4ea8-ad5d-17fa0d83e54a | 013a149a-9839-45bf-b5c9-0fabef0c7747 | Full body plan               | 2021-02-27 |
      | d528cf56-dd82-4dfe-89c1-a535c9699a7d | 569c3f90-987f-459d-ae50-37f6d1a707d3 | Full body plan (not started) | 2021-02-02 |
