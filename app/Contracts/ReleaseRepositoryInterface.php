<?php
namespace App\Contracts;

interface ReleaseRepositoryInterface
{
    public function all($id);
    public function store($release);
    public function fetchById($id);
    public function update($id);
    public function delete($id);


}
