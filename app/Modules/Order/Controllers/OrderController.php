<?php

namespace App\Modules\Order\Controllers;

use App\Contracts\OrderRepositoryInterface;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    private $orders;

    public function __construct(
        OrderRepositoryInterface $orders

    ) {

        $this->orders = $orders;
    }

    public function showOrders()
    {

        return view('Order::showOrders', [
            'orders' => $this->orders->all(),
        ]);
    }



    public function showOrder($id)
    {

        return view('Order::showOrder', [
            'order' => $this->orders->fetchById($id),
        ]);
    }
}
