<?php
namespace App\Repositories;

use App\Contracts\CollectionRepositoryInterface;
use App\Modules\Collection\Models\Collection;

class CollectionRepository implements CollectionRepositoryInterface
{
    public function all()
    {
        return Collection::all();

    }
    public function store($collection)
    {}
    public function fetchById($id)
    {
        return Collection::with('books')->find($id);
    }
    public function update($id)
    {}
    public function delete($id)
    {}
}
