<?php
namespace App\Repositories;

use App\Contracts\ImageRepositoryInterface;
use App\Contracts\RoleRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Modules\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    private $roles, $image;
    public function __construct(RoleRepositoryInterface $roles, ImageRepositoryInterface $image)
    {
        $this->roles = $roles;
        $this->image = $image;
    }

    public function register($user)
    {

        isset($user['photo']) ? $photo = $this->image->uploadFile($user['photo'], '/img/users') : '';

        return User::create([
            'full_name' => $user['full_name'],
            'email' => $user['email'],
            'password' => bcrypt($user['password']),
            'photo' => isset($photo) ? $photo : null,
            'role_id' => USER::ROLE_USER,
        ]);

    }

    public function login($user)
    {

        $user = Auth::attempt($user);

        if ($user) {
            $user = Auth::user();

            // Normal user

            if ($user->isAdmin() || !$user->active) {

                return [
                    'status' => 404,
                ];
            }

            return [
                'token' => $user->createToken('books')->accessToken,
                'user' => $user,
                'status' => 200,
            ];

        }

        return [
            'status' => 404,
        ];

    }

    public function loginAdmin($credentials)
    {
        $credentialsAuth = $credentials;
        unset($credentialsAuth['type']);

        $user = Auth::attempt($credentialsAuth);

        if ($user) {
            $user = Auth::user();
            switch ($credentials['type']) {

                case 1:
                    // Admin

                    if ($user->role->name == 'user' || !$user->active || $user->active == 2) {
                        $this->logout();
                        return false;
                    }
                    return $user;

                    break;
            }
            return $user;
        }
        return false;

    }
    public function logout()
    {

        Auth::logout();
        return true;

    }

    public function all()
    {
        return User::all();

    }
    public function fetchById($id)
    {
        return User::find($id);
    }

    public function delete($userId)
    {
        $checkUser = $this->fetchById($userId);
        if ($checkUser) {
            $checkUser->delete();
            return true;
        }
        return false;

    }

    public function updateUser($user)
    {
        $checkUser = $this->fetchById($user['user_id']);
        if ($checkUser) {
            $photo = null;
            if (isset($user['photo']) && $user['photo'] != $checkUser->photo) {
             
                $this->image->deleteFile($checkUser->photo);
                $photo = $this->image->uploadFile($user['photo'], '/img/users');
            }

            return $checkUser->update([
                'full_name' => isset($user['full_name']) ? $user['full_name'] : $checkUser->full_name,
                'description' => isset($user['description']) ? $user['description'] : $checkUser->description,
                'country' => isset($user['country']) ? $user['country'] : $checkUser->country,
                'photo' => $photo,
                'first_login' => $user['first_login'],
            ]);
        }
    }
    public function updateAdmin($user)
    {

        $checkUser = $this->fetchById($user['user_id']);

        if ($checkUser) {

            $checkUser->update([
                'active' => isset($user['active']),
                'role_id' => $user['role_id'],
            ]);

            return true;

        }
        return false;

    }

    public function getUserStatistics($type)
    {

        switch ($type) {
            // Tous
            case 1:
                $subscribedUsers = User::whereHas('role', function ($q) {
                    $q->where('name', 'user');
                })->count();

                $subscribedActiveUsers = User::where('active', 1)
                    ->whereHas('role', function ($q) {
                        $q->where('name', 'user');
                    })->count();

                $response = [
                    'all' => $subscribedUsers,
                    'active' => $subscribedActiveUsers,
                ];

                return $response;
                break;

            case 2:

                // Aujourd'hui

                $subscribedUsers = User::whereDate('created_at', '=', Carbon::today())
                    ->whereHas('role', function ($q) {
                        $q->where('name', 'user');
                    })->count();

                $subscribedActiveUsers = User::where('active', 1)
                    ->whereDate('created_at', '=', Carbon::today())
                    ->whereHas('role', function ($q) {
                        $q->where('name', 'user');
                    })->count();

                $response = [
                    'all' => $subscribedUsers,
                    'active' => $subscribedActiveUsers,
                ];

                return $response;
                break;
            case 3:
                // Cette semaine

                $subscribedUsers = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->whereHas('role', function ($q) {
                        $q->where('name', 'user');
                    })->count();

                $subscribedActiveUsers = User::where('active', 1)
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->whereHas('role', function ($q) {
                        $q->where('name', 'user');
                    })->count();

                $response = [
                    'all' => $subscribedUsers,
                    'active' => $subscribedActiveUsers,
                ];

                return $response;
                break;
            case 4:
                // Ce mois

                $subscribedUsers = User::whereMonth('created_at', Carbon::now()->month)
                    ->whereHas('role', function ($q) {
                        $q->where('name', 'user');
                    })->count();

                $subscribedActiveUsers = User::where('active', 1)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereHas('role', function ($q) {
                        $q->where('name', 'user');
                    })->count();

                $response = [
                    'all' => $subscribedUsers,
                    'active' => $subscribedActiveUsers,
                ];

                return $response;
                break;
            default:return false;

        }
    }
    public function block($id)
    {

        $checkUser = $this->fetchById($id);
        if ($checkUser) {
            return $checkUser->update(['active' => 2]);
        }
        return false;
    }

    public function unblock($id)
    {
        $checkUser = $this->fetchById($id);
        if ($checkUser) {
            return $checkUser->update(['active' => 1]);
        }
        return false;
    }

    public function notActive()
    {
        return User::where('active', 0)->count();
    }

}
