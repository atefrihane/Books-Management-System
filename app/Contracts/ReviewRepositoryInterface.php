<?php
namespace App\Contracts;

interface ReviewRepositoryInterface
{
    public function all();
    public function store($review);
    public function fetchById($id);
    public function update($Review);
    public function delete($id);

}
