<?php

namespace App\Modules\User\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\RoleRepositoryInterface;
use App\Contracts\UserRepositoryInterface;

class UserController extends Controller
{
    private $users, $roles;
    public function __construct(UserRepositoryInterface $users, RoleRepositoryInterface $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }

    public function handleLogin(Request $request)
    {
     

        $checkUser = $this->users->loginAdmin($request->except('_token'));

        if ($checkUser) {
         
            return redirect()->route('showHome');
        }

        alert()->error('Wrong credentials', 'Oups!')->persistent('Close');
        return redirect()->back();

    }

    public function handleLogout(Request $request)
    {

        $checkLogout = $this->users->logout();
        if ($checkLogout) {
            return redirect()->route('showHome');
        }
        alert()->error('Opération refusée', 'Oups!')->persistent('Fermer');
        return redirect()->back();
    }

    public function showUsers()
    {

        return view('User::showUsers', ['users' => $this->users->all()]);
    }

    public function showAddUser()
    {

        return view('User::showAddUser' , ['roles' => $this->roles->all()]);

    }

    

    public function showUser($id)
    {

        $user = $this->users->fetchById($id);

        if ($user) {
            return view('User::showUser', ['user' => $user]);
        }
        return view('General::showNotFound');

    }

    public function showUpdateUser($id)
    {

        $user = $this->users->fetchById($id);

        if ($user) {
            return view('User::showUpdateUser', ['user' => $user , 'roles' => $this->roles->all()]);
        }
        return view('General::showNotFound');

    }
}
