<?php

namespace App\Entity;

use App\Repository\PayoutRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PayoutRepository::class)
 */
class Payout
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Seller::class, inversedBy="payouts")
     * @ORM\JoinColumn(name="seller_id", referencedColumnName="id", nullable=false)
     */
    private $Seller;

    /**
     * @ORM\ManyToOne(targetEntity=Currency::class)
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id", nullable=false)
     */
    private $Currency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeller(): ?Seller
    {
        return $this->Seller;
    }

    public function setSeller(?Seller $Seller): self
    {
        $this->Seller = $Seller;

        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->Currency;
    }

    public function setCurrency(?Currency $Currency): self
    {
        $this->Currency = $Currency;

        return $this;
    }
}
