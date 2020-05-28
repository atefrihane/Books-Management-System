<?php
namespace App\Contracts;

interface AuthorRepositoryInterface
{
    public function all();
    public function store($author);
    public function fetchById($id);
    public function update($author);
    public function delete($id);
}
