<?php

namespace App\Modules\Order\Controllers;

use App\Contracts\OrderRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder;
use App\Http\Requests\UpdateOrderStatus;
use App\Http\Resources\Order as OrderResource;

class OrderControllerApi extends Controller
{
    private $orders;

    public function __construct(
        OrderRepositoryInterface $orders

    ) {

        $this->orders = $orders;
    }

    public function handleStoreOrder(StoreOrder $request)
    {

        $saveOrder = $this->orders->store($request->all());
        if ($saveOrder) {

            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);
    }

    public function handleSaveOrder(StoreOrder $request)
    {

        $saveOrder = $this->orders->store($request->all());
        if ($saveOrder) {

            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);
    }

    public function handleUpdateStatus(UpdateOrderStatus $request)
    {

        $updateOrderStatus = $this->orders->updateStatus($request->all());
        if ($updateOrderStatus) {

            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);

    }

    public function showUserOrders($id)
    {

        $showUserOrders = $this->orders->getUserOrders($id);
        if ($showUserOrders) {

            return response()->json(['status' => 200, 'orders' => OrderResource::collection($showUserOrders)]);
        }
        return response()->json(['status' => 404]);

    }
}
