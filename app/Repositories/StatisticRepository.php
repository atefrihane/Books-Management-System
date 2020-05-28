<?php
namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Contracts\StatisticRepositoryInterface;
use App\Contracts\UserRepositoryInterface;

class StatisticRepository implements StatisticRepositoryInterface
{
    private $users, $products;

    public function __construct(
        UserRepositoryInterface $users,
        ProductRepositoryInterface $products
    ) {
        $this->users = $users;
        $this->products = $products;
    }

    public function getStatistics($type)
    {
        // get User statistics
        $usersStatistics = $this->users->getUserStatistics($type);

        // get count of digital ressources
        $getDigitalRessources = $this->products->getDigitalRessources($type);

        // get count of  downloaded digital ressources
        $getDigitalDownloadedRessources = $this->products->getDigitalDownloadedRessources(1);

    }

}
