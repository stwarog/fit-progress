<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exceptions\NotFoundException;
use App\Domain\Repository\PlanById;
use App\Infrastructure\ORM\Mapping\PlanTrait;
use Countable as Countable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\Pure;

final class Training implements Countable
{
    use PlanTrait;

    private string $id;
    private string $name;
    private string $date;
    private ?string $planId;
    private string $status;

    private Collection $activities;

    public function __construct(
        TrainingId $id,
        Name $name,
        PlanById $exists,
        ?Date $date = null,
        ?PlanId $planId = null
    ) {
        if (!empty($planId) && empty($exists->findOne($planId))) {
            throw new NotFoundException('Plan not found for: ' . $planId);
        }
        $this->id = (string)$id;
        $this->name = (string)$name;
        $this->date = $date ? (string)$date : (string)Date::now();
        $this->planId = $planId ? (string)$planId : $planId;
        $this->status = (string)new Status(Status::PLANNED);
        $this->activities = new ArrayCollection();
    }

    public static function create(Name $name, PlanById $exists, ?Date $date = null, ?PlanId $planId = null): self
    {
        return new self(
            TrainingId::random(),
            $name,
            $exists,
            $date,
            $planId
        );
    }

    public function add(Activity $exercise): void
    {
        $this->activities->add($exercise);
        $this->status = (string)(new Status(Status::STARTED));
    }

    public function count(): int
    {
        return count($this->activities);
    }

    #[Pure] public function getId(): TrainingId
    {
        return new TrainingId($this->id);
    }

    public function getStatus(): Status
    {
        return new Status($this->status);
    }
}
