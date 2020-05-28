<?php
namespace App\Contracts;

interface ArticleRepositoryInterface
{
    public function all();
    public function store($article);
    public function fetchById($id);
    public function update($id);
    public function delete($id);
}
