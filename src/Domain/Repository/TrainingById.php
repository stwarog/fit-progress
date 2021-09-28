<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Training;
use App\Domain\TrainingId;

interface TrainingById
{
    public function findOne(TrainingId $id): ?Training;
}
