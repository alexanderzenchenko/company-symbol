<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ORM\Index(columns: ['symbol'], name: 'symbol_index')]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $symbol = null;

    #[ORM\Column(length: 255)]
    private ?string $companyName = null;

    #[ORM\Column(length: 1)]
    private ?string $financialStatus = null;

    #[ORM\Column(length: 1)]
    private ?string $MarketCategory = null;

    #[ORM\Column]
    private ?float $RoundLotSize = null;

    #[ORM\Column(length: 255)]
    private ?string $SecurityName = null;

    #[ORM\Column(length: 1)]
    private ?string $TestIssue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getFinancialStatus(): ?string
    {
        return $this->financialStatus;
    }

    public function setFinancialStatus(string $financialStatus): self
    {
        $this->financialStatus = $financialStatus;

        return $this;
    }

    public function getMarketCategory(): ?string
    {
        return $this->MarketCategory;
    }

    public function setMarketCategory(string $MarketCategory): self
    {
        $this->MarketCategory = $MarketCategory;

        return $this;
    }

    public function getRoundLotSize(): ?float
    {
        return $this->RoundLotSize;
    }

    public function setRoundLotSize(float $RoundLotSize): self
    {
        $this->RoundLotSize = $RoundLotSize;

        return $this;
    }

    public function getSecurityName(): ?string
    {
        return $this->SecurityName;
    }

    public function setSecurityName(string $SecurityName): self
    {
        $this->SecurityName = $SecurityName;

        return $this;
    }

    public function getTestIssue(): ?string
    {
        return $this->TestIssue;
    }

    public function setTestIssue(string $TestIssue): self
    {
        $this->TestIssue = $TestIssue;

        return $this;
    }
}
