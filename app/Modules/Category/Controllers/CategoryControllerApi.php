<?php

namespace App\Modules\Category\Controllers;

use App\Contracts\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;

class CategoryControllerApi extends Controller
{
    private $categories;
    public function __construct(CategoryRepositoryInterface $categories)
    {
        $this->categories = $categories;

    }

    public function handleAddCategory(StoreCategory $request)
    {
        $addCategory = $this->categories->store($request->name);
        if ($addCategory) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 405]);
    }

    public function handleUpdateCategory(UpdateCategory $request)
    {
        $updateCategoryResponse = $this->categories->update($request->all());
        switch ($updateCategoryResponse) {
            case 1:
                return response()->json(['status' => 200]); // done
                break;
            case 0:
                return response()->json(['status' => 405]); // name already in use
                break;

            case -1:
                return response()->json(['status' => 404]); // category not found
                break;
        }

    }

    public function handleDeleteCategory($id)
    {
        $deleteCategory = $this->categories->delete($id);
        if ($deleteCategory) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);
    }
}
