<?php
namespace App\Contracts;

interface CollectionRepositoryInterface
{
    public function all($type);
    public function fetchById($id);
    public function delete($id);
    public function update($id);
    public function store($collection);
}
