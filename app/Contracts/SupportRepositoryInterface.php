<?php
namespace App\Contracts;

interface SupportRepositoryInterface
{
    public function all();
    public function store($store);
    public function findById($id);
    public function delete($id);
}
