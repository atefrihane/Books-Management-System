<?php

use Illuminate\Database\Seeder;
use App\Modules\Language\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            ['name' => 'arabe'],
            ['name' => 'anglais'],
            ['name' => 'français'],

        ];
        Language::insert($languages);
    }
}
