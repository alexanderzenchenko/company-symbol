<?php

namespace App\Entity;

class HistoricalQuoteSearchData
{
    protected string $companySymbol;
    protected \DateTime $startDate;
    protected \DateTime $endDate;
    protected string $email;

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getCompanySymbol(): string
    {
        return $this->companySymbol;
    }

    /**
     * @param string $companySymbol
     */
    public function setCompanySymbol(string $companySymbol): void
    {
        $this->companySymbol = $companySymbol;
    }
}
