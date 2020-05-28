<?php
namespace App\Repositories;

use App\Contracts\LanguageRepositoryInterface;
use App\Modules\Language\Models\Language;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function all()
    {
        return Language::get();
    }
    public function store()
    {}
    public function fetchById()
    {}
    public function update()
    {}
    public function delete()
    {}
}
