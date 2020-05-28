<?php

namespace App\Modules\Support\Controllers;

use App\Contracts\SupportRepositoryInterface;
use App\Http\Controllers\Controller;

class SupportController extends Controller
{
    private $supports;
    public function __construct(SupportRepositoryInterface $supports)
    {
        $this->supports = $supports;
    }

    public function showSupports()
    {
        return view('Support::showSupports', ['supports' => $this->supports->all()]);
    }
    public function showSupport($id)
    {
        $checkSupport = $this->supports->findById($id);

        if ($checkSupport) {
            return view('Support::showSupport', ['support' => $checkSupport]);
        }

        return view('General::showNotFound');

    }
}
