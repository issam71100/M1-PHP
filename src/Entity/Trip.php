<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TripRepository")
 */
class Trip
{

    public function __construct(string $transport, \DateTime $duration, int $price, City $city_departure, City $city_arrival) {
        $this->setCityArrival($city_arrival);
        $this->setCityDeparture($city_departure);
        $this->setDuration($duration);
        $this->setPrice($price);
        $this->setTransport($transport);
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $transport;

    /**
     * @ORM\Column(type="time")
     */
    private $duration;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="trips")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city_departure;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="trips_landing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city_arrival;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransport(): ?string
    {
        return $this->transport;
    }

    public function setTransport(string $transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(\DateTimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCityDeparture(): ?City
    {
        return $this->city_departure;
    }

    public function setCityDeparture(?City $city_departure): self
    {
        $this->city_departure = $city_departure;

        return $this;
    }

    public function getCityArrival(): ?City
    {
        return $this->city_arrival;
    }

    public function setCityArrival(?City $city_arrival): self
    {
        $this->city_arrival = $city_arrival;

        return $this;
    }
}
