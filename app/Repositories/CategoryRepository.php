<?php
namespace App\Repositories;

use App\Modules\Category\Models\Category;
use App\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(){
        return Category::all();
    }
    public function store(){}
    public function fetchById(){}
    public function update(){}
    public function delete(){}
}


