<?php
namespace App\Contracts;

interface RoleRepositoryInterface
{

    public function all();
    public function getRole($type);
}
