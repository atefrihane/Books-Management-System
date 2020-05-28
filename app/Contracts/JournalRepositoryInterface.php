<?php
namespace App\Contracts;

interface JournalRepositoryInterface
{
    public function all();
    public function store($journal);
    public function fetchById($id);
    public function update($id);
    public function delete($id);
}
