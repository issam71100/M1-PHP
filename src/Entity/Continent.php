<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContinentRepository")
 */
class Continent
{
    public function __construct(string $name, string $image) {
        $this->contries = new ArrayCollection();
        
        $this->setName($name);
        $this->setImage($image);
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="Country", mappedBy="continent")
     */
    private $contries;

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
     * @return Collection|Country[]
     */
    public function getContries(): Collection
    {
        return $this->contries;
    }

    public function addContry(Country $contry): self
    {
        if (!$this->contries->contains($contry)) {
            $this->contries[] = $contry;
            $contry->setContinent($this);
        }

        return $this;
    }

    public function removeContry(Country $contry): self
    {
        if ($this->contries->contains($contry)) {
            $this->contries->removeElement($contry);
            // set the owning side to null (unless already changed)
            if ($contry->getContinent() === $this) {
                $contry->setContinent(null);
            }
        }

        return $this;
    }

}
