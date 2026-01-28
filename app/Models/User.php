<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model
{
    protected $table = 'users';

    public function findByUsername($username)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ?");
            $stmt->execute([$username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $this->handleError('Failed to find user by username', $e);
        }
    }

    public function findByEmail($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $this->handleError('Failed to find user by email', $e);
        }
    }

    public function authenticate($username, $password)
    {
        try {
            $user = $this->findByUsername($username);
            
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            
            return false;
        } catch (\Exception $e) {
            $this->handleError('Authentication failed', $e);
        }
    }

    public function createUser($data)
    {
        try {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            return $this->create($data);
        } catch (\Exception $e) {
            $this->handleError('Failed to create user', $e);
        }
    }
}
