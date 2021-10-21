<?php

declare(strict_types=1);

namespace App\Training\Domain;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Training\Domain\Exceptions\InvalidStatus;
use App\Training\Domain\Repository\PlanById;
use Countable as Countable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\Pure;

final class Training implements Countable
{
    private string $id;
    private string $name;
    private string $date;
    private ?string $planId;
    private string $status;
    private ?string $dateStarted;

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
        $this->start();
        $this->activities->add($exercise);
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

    public function start(): void
    {
        if (!in_array($this->status, [Status::PLANNED, Status::STARTED])) {
            throw new InvalidStatus('Invalid Training status');
        }

        $this->status = (string)(new Status('started'));
        $this->dateStarted = (string)DateTime::now();
    }

    public function getDateStarted(): ?DateTime
    {
        return !empty($this->dateStarted) ? new DateTime($this->dateStarted) : null;
    }

    public function end(): void
    {
        $this->status = (string)(new Status('ended'));
    }

    public function skip(): void
    {
        if ($this->status !== Status::PLANNED) {
            throw new InvalidStatus('Invalid Training status');
        }

        $this->status = (string)(new Status('skipped'));
    }
}
