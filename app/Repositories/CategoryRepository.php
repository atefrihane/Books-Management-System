<?php
namespace App\Repositories;

use App\Contracts\CategoryRepositoryInterface;
use App\Modules\Category\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::all();
    }

    public function count()
    {
        return Category::count();
    }
    public function store($category)
    {

        $checkExistingName = $this->fetchByName($category);
        if (!$checkExistingName) {
            Category::create([
                'name' => $category,
            ]);
            return true;
        }
        return false;
    }
    public function fetchById($id)
    {
        return Category::find($id);
    }
    public function fetchByName($category)
    {
        return Category::whereName($category)->first();
    }
    public function update($category)
    {
        $checkCategory = $this->fetchById($category['id']);
        if ($checkCategory) {
            $checkCategory->update([
                'name' => $category['name'],
            ]);
            return 1;
        }
        return -1;

    }
    public function delete($id)
    {
        $checkCategory = $this->fetchById($id);
        if ($checkCategory) {
            return $checkCategory->delete();

        }
        return false;
    }
}
