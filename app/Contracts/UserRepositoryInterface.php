<?php
namespace App\Contracts;

interface UserRepositoryInterface
{
    public function register($user);
    public function login($user);
    public function all();
    public function delete($userId);
    public function update($userId);
    public function fetchById($userId);
    public function logout();
}
