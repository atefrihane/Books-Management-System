<?php
namespace App\Repositories;

use App\Contracts\RoleRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Jobs\SendEmail;
use App\Mail\ActivationEmail;
use App\Modules\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    private $roles;
    public function __construct(RoleRepositoryInterface $roles)
    {
        $this->roles = $roles;
    }

    public function register($user)
    {

        $checkRole = $this->roles->getRole($user['type']);

        if ($checkRole) {
            unset($user['type']);

            $user['role_id'] = $checkRole;
            $user['password'] = bcrypt($user['password']);
            $createUser = User::create($user);
            if (!$createUser->active && !$createUser->isAdmin()) {
                $createUser->sendApiEmailVerificationNotification();
            }

            if ($createUser->active) {
                $createUser->update(['email_verified_at' => Carbon::now()]);
                SendEmail::dispatch($createUser, new ActivationEmail($createUser));
            }

            return true;
        }

        return false;

    }

    public function login($credentials)
    {
        $credentialsAuth = $credentials;
        unset($credentialsAuth['type']);

        $user = Auth::attempt($credentialsAuth);

        if ($user) {
            $user = Auth::user();
            switch ($credentials['type']) {
                case 0:
                    // Normal user
                    if ($user->active == 2) {
                        return 406;

                    }
                    if (!$user->email_verified_at) {
                        return 405;

                    }
                    if ($user->role->name != 'user' || !$user->active) {
                        $this->logout();
                        return 401;
                    }
                    $response = [
                        'token' => $user->createToken('books')->accessToken,
                        'user' => $user,
                        'status' => 200,
                    ];
                    return $response;

                    break;
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
        return 401;

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
    public function update($user)
    {

        $checkUser = $this->fetchById($user['user_id']);

        if ($checkUser) {
            $sendEmail = false;
            if (isset($user['password']) && !(Hash::check($user['password'], $checkUser->password))) {
                $response = ['status' => 0, 'user' => null];
                return $response;

            }
            if ((isset($user['active']) && $checkUser->active != $user['active'] && $user['active'] == 1 && !$checkUser->isAdmin())) {
                $sendEmail = true;

            }

            $checkUser->update([
                'first_name' => isset($user['first_name']) ? $user['first_name'] : $checkUser->first_name,
                'last_name' => isset($user['last_name']) ? $user['last_name'] : $checkUser->last_name,
                'occupation' => isset($user['occupation']) ? $user['occupation'] : $checkUser->occupation,
                'active' => isset($user['active']) ? $user['active'] : $checkUser->active,
                'institution' => isset($user['institution']) ? $user['institution'] : $checkUser->institution,
                'country' => isset($user['country']) ? $user['country'] : $checkUser->country,
                'zipcode' => isset($user['zipcode']) ? $user['zipcode'] : $checkUser->zipcode,
                'city' => isset($user['city']) ? $user['city'] : $checkUser->city,
                'address' => isset($user['address']) ? $user['address'] : $checkUser->address,
                'phone' => isset($user['phone']) ? $user['phone'] : $checkUser->phone,
                'email' => isset($user['email']) ? $user['email'] : $checkUser->email,
                'password' => isset($user['new_password']) ? bcrypt($user['new_password']) : $checkUser->password,
                'role_id' => isset($user['role_id']) ? $user['role_id'] : $checkUser->role_id,
            ]);
            if ($sendEmail) {
                SendEmail::dispatch($checkUser, new ActivationEmail($checkUser));

            }
            $response = ['status' => 1, 'user' => $checkUser];
            return $response;

        }
        $response = ['status' => -1, 'user' => null];
        return $response;

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
