<?php

namespace App\Modules\Category\Controllers;

use App\Contracts\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    private $categories;
    public function __construct(CategoryRepositoryInterface $categories)
    {
        $this->categories = $categories;

    }

    public function showCategories()
    {
        return view('Category::showCategories', ['categories' => $this->categories->all()]);

    }

    public function showUpdateCategory($id)
    {
        $checkCategory = $this->categories->fetchById($id);
        if ($checkCategory) {
            return view('Category::showUpdateCategory', ['category' => $checkCategory]);
        }
        return view('General::showNotFound');

    }
    public function showCategory($id)
    {
        $checkCategory = $this->categories->fetchById($id);
        if ($checkCategory) {
            return view('Category::showCategory', ['category' => $checkCategory]);
        }
        return view('General::showNotFound');

    }

}
