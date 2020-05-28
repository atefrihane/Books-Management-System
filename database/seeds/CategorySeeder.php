<?php

use App\Modules\Category\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'psychology'],
            ['name' => 'sociology'],

        ];

        Category::insert($categories);
    }
}
