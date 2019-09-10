<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MonthRepository")
 */
class Month
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $temperature_avg;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity", inversedBy="months")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?\DateTimeInterface
    {
        return $this->name;
    }

    public function setName(\DateTimeInterface $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTemperatureAvg(): ?int
    {
        return $this->temperature_avg;
    }

    public function setTemperatureAvg(int $temperature_avg): self
    {
        $this->temperature_avg = $temperature_avg;

        return $this;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }
}
