<?php
namespace App\Contracts;

interface OrderRepositoryInterface
{
    public function all();
    public function store($order);
    public function fetchById($id);
    public function update($order);
    public function delete($id);

}
