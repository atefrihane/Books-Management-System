<?php
namespace App\Contracts;

interface CategoryRepositoryInterface
{
    public function all();
    public function store($category);
    public function fetchById($id);
    public function fetchByName($category);
    public function update($category);
    public function delete($category);
}
