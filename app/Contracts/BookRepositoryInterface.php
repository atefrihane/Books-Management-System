<?php
namespace App\Contracts;

interface BookRepositoryInterface
{
    public function all($type);
    public function store($book);
    public function fetchById($id);
    public function update($id);
    public function delete($id);
}
