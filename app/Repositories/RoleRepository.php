<?php
namespace App\Repositories;

use App\Contracts\RoleRepositoryInterface;
use App\Modules\Role\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{

    public function all()
    {
        return Role::all();
    }
    public function getRole($type)
    {

        switch ($type) {
            case 0:
                $checkRole = Role::where('name', 'user')->first();
                $checkRole ? $checkRole = $checkRole->id : $checkRole = false;
                return $checkRole;

                break;

            case 1:
                $checkRole = Role::where('name', 'superadmin')->first();
                $checkRole ? $checkRole = $checkRole->id : $checkRole = false;
                return $checkRole;

                break;

            case 2:
                $checkRole = Role::where('name', 'admin')->first();
                $checkRole ? $checkRole = $checkRole->id : $checkRole = false;
                return $checkRole;

                break;
            default:return false;
        }

    }

}
