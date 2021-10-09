<?php
namespace App\Repositories;
use App\User;

interface UserRepositoryInterface
{
 public function getUsers();

 public function getUser($id);

 public function createUser($user);

 public function updateUser($user,$id);

 public function deleteUser($id);

 public function checkEmailExist($email);

 public function getRole($user_id);

 public function createRole($user_id);

 public function UpdateRole($role,$user_id);

}