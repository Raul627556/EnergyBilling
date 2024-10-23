<?php

namespace App\Dto;

class DateRangeDTO
{

    /** @var string */
    private string $startDate;

    /** @var string */
    private string $endDate;

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): DateRangeDTO
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function setEndDate(string $endDate): DateRangeDTO
    {
        $this->endDate = $endDate;
        return $this;
    }




}