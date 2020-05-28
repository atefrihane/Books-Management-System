<?php
namespace App\Contracts;

interface LanguageRepositoryInterface
{
    public function all();
    public function store();
    public function fetchById();
    public function update();
    public function delete();
}
