<?php
namespace App\Repositories;

use App\Contracts\OrderRepositoryInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Modules\Order\Models\Order;
use Illuminate\Support\Str;

class OrderRepository implements OrderRepositoryInterface
{
    protected $users, $products;
    public function __construct(UserRepositoryInterface $users, ProductRepositoryInterface $products)
    {
        $this->users = $users;
        $this->products = $products;
    }
    public function all()
    {
        return Order::all();
    }

    public function countOrders()
    {
        return Order::count();
    }
    public function getLastId()
    {
        return $this->countOrders() > 0 ? $id = $this->all()->last()->id + 1 : 1;

    }

    public function store($order)
    {
        $nextId = $this->getLastId();
        $newOrder = Order::create([
            'status' => 0,
            'code' => Str::random(10) . '-' . $nextId,
            'user_id' => $order['user_id'],

        ]);
        // attach order_id to products

        foreach ($order['products'] as &$product) {

            $product['order_id'] = $newOrder->id;

        }

        $newOrder->products()->attach($order['products']);
        return true;

    }

    public function updateStatus($order)
    {
        $checkOrder = $this->fetchById($order['id']);
        if ($checkOrder) {
            return $checkOrder->update(['status' => $order['status']]);
        }
        return false;

    }
    public function fetchById($id)
    {
        return Order::find($id);
    }

    public function getUserOrders($id)
    {
        $checkUser = $this->users->fetchById($id);
        if ($checkUser) {
            return Order::where('user_id', $id)->get();

        }
        return false;

    }
    public function update($id)
    {}
    public function delete($id)
    {}
}
