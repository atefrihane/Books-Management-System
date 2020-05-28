<?php
namespace App\Contracts;

interface StatisticRepositoryInterface
{
    public function getStatistics($type);
}
