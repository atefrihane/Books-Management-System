<?php

namespace App\Modules\General\Controllers;

use App\Contracts\StatisticRepositoryInterface;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    private $statistics;
    public function __construct(StatisticRepositoryInterface $statistics)
    {
        $this->statistics = $statistics;
    }

    public function showHome()
    {

        return view('General::showHome', [
            'statistics' => $this->statistics->getStatistics(),
        ]);
    }

    public function showLogin()
    {

        return view('General::showLogin');
    }

    public function showNotFoundPage()
    {
        return view('General::showNotFound');

    }
}
