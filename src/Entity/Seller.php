<?php

namespace App\Entity;

use App\Repository\SellerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SellerRepository::class)
 */
class Seller
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Payout::class, mappedBy="Seller")
     */
    private $payouts;

    public function __construct()
    {
        $this->payouts = new ArrayCollection();
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

    /**
     * @return Collection|Payout[]
     */
    public function getPayouts(): Collection
    {
        return $this->payouts;
    }

    public function addPayout(Payout $payout): self
    {
        if (!$this->payouts->contains($payout)) {
            $this->payouts[] = $payout;
            $payout->setSeller($this);
        }

        return $this;
    }

    public function removePayout(Payout $payout): self
    {
        if ($this->payouts->removeElement($payout)) {
            // set the owning side to null (unless already changed)
            if ($payout->getSeller() === $this) {
                $payout->setSeller(null);
            }
        }

        return $this;
    }
}
