<?php
namespace App\Contracts;

interface CategoryRepositoryInterface
{
    public function all();
    public function store();
    public function fetchById();
    public function update();
    public function delete();
}
