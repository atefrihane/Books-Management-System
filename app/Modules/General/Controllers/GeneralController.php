<?php

namespace App\Modules\General\Controllers;

use App\Contracts\StatisticRepositoryInterface;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{



    public function showHome()
    {

        return view('General::showHome');
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
