<?php

declare(strict_types=1);

namespace App\Training\Domain\Repository;

use App\Training\Domain\Training;
use App\Training\Domain\TrainingId;

interface TrainingById
{
    public function findOne(TrainingId $id): ?Training;
}
