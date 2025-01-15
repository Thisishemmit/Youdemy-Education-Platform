<?php
namespace App\Models;
use Helpers\Database;

class User {
    protected $db;
    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $created_at;
    protected $updated_at;
    protected $role;
    protected $status;

    public function __construct(Database $db)
    {
       $this->db = $db;
    }

    public static function create(Database $db, $username, $email, $password, $role, $status)
    {
        $sql = 'INSERT INTO Users (username, email, password, role, status) VALUES (:username, :email , :password, :role, :status)';
        $params = [
            ':username' => $username,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':role' => $role,
            ':status' => $status
        ];
        if ($db->query($sql, $params)) {
            $id = $db->lastInsertId();
            return User::loadById($db, $id);
        } else {
            return false;
        }
    }

    public static function loadById(Database $db, $id){
        $sql = 'SELECT * FROM Users WHERE id = :id';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);
        if ($result) {
            $user = new self($db);
            $user->hydrate($result);
            return $user;
        } else {
            return false;
        }

    }

    protected function hydrate($data)
    {
        $this->id = $data['id'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
        $this->role = $data['role'];
        $this->status = $data['status'];
    }

    public static function all(Database $db)
    {
        $sql = 'SELECT * FROM Users';
        $result = $db->fetchAll($sql);
        $users = [];
        if ($result) {
            foreach ($result as $data) {
                $user = new User($db);
                $user->hydrate($data);
                $users[] = $user;
            }
        } else {
            return false;
        }
        return $users;
    }

    public function verifyPassword($password){
        return password_verify($password, $this->password);
    }

    public function update($username, $email, $password, $role, $status)
    {
        $sql = 'update users set username = :username, email = :email, password = :password, role = :role, status = :status where id = :id';
        $params = [
            ':id' => $this->id,
            ':username' => $username,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':role' => $role,
            ':status' => $status
        ];
        if ($this->db->query($sql, $params)) {
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->role = $role;
            $this->status = $status;
            return true;
        } else {
            return false;
        }
    }

    public function updatePassword($password)
    {
        $sql = 'UPDATE Users SET password = :password WHERE id = :id';
        $params = [
            ':id' => $this->id,
            ':password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        return $this->db->query($sql, $params);
    }

    public function updateStatus($status)
    {
        $sql = 'UPDATE Users SET status = :status WHERE id = :id';
        $params = [
            ':id' => $this->id,
            ':status' => $status
        ];
        return $this->db->query($sql, $params);
    }

    public function updateRole($role)
    {
        $sql = 'UPDATE Users SET role = :role WHERE id = :id';
        $params = [
            ':id' => $this->id,
            ':role' => $role
        ];
        return $this->db->query($sql, $params);
    }

    public function updateUsername($username)
    {
        $sql = 'UPDATE Users SET username = :username WHERE id = :id';
        $params = [
            ':id' => $this->id,
            ':username' => $username
        ];
        return $this->db->query($sql, $params);
    }

    public function updateEmail($email)
    {
        $sql = 'UPDATE Users SET email = :email WHERE id = :id';
        $params = [
            ':id' => $this->id,
            ':email' => $email
        ];
        return $this->db->query($sql, $params);
    }

    public function delete()
    {
        $sql = 'DELETE FROM Users WHERE id = :id';
        $params = [':id' => $this->id];
        return $this->db->query($sql, $params);
    }

    public function suspend()
    {
        if ($this->status !== 'suspended') {
            if ($this->updateStatus('suspended')) {
                $this->status = 'suspended';
                return true;
            }
        } else {
            return false;
        }
    }

    public function activate()
    {
        if ($this->status !== 'active') {
            if ($this->updateStatus('active')) {
                $this->status = 'active';
                return true;
            }
        } else {
            return false;
        }
    }
}

