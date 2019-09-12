<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activity", mappedBy="city")
     */
    private $activities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hosting", mappedBy="city")
     */
    private $hostings;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="cities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contry;

    public function __construct($name = null, $image = null, $country = null)
    {
        $this->activities = new ArrayCollection();
        $this->hostings = new ArrayCollection();
        $this->setName($name);
        $this->setImage($image);
        $this->setContry($country);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setCity($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activities->contains($activity)) {
            $this->activities->removeElement($activity);
            // set the owning side to null (unless already changed)
            if ($activity->getCity() === $this) {
                $activity->setCity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Hosting[]
     */
    public function getHostings(): Collection
    {
        return $this->hostings;
    }

    public function addHosting(Hosting $hosting): self
    {
        if (!$this->hostings->contains($hosting)) {
            $this->hostings[] = $hosting;
            $hosting->setCity($this);
        }

        return $this;
    }

    public function removeHosting(Hosting $hosting): self
    {
        if ($this->hostings->contains($hosting)) {
            $this->hostings->removeElement($hosting);
            // set the owning side to null (unless already changed)
            if ($hosting->getCity() === $this) {
                $hosting->setCity(null);
            }
        }

        return $this;
    }

    public function getContry(): ?Country
    {
        return $this->contry;
    }

    public function setContry(?Country $contry): self
    {
        $this->contry = $contry;

        return $this;
    }
}
