<?php
namespace App\Models;

use Helpers\Database;
use App\Models\User;

class Student extends User {
    public function __construct(Database $db) {
        parent::__construct($db);
    }

    public static function create(Database $db, $username, $email, $password, $role = 'student', $status = 'active') {
        return User::create($db, $username, $email, $password, $role, $status);
    }

    public static function loadById(Database $db, $id)
    {
        $sql = 'SELECT * FROM Users WHERE id = :id AND role = "student"';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);
        if ($result) {
            $student = new self($db);
            $student->hydrate($result);
            return $student;
        } else {
            return false;
        }
    }

    public static function loadByEmail(Database $db, $email)
    {
        $sql = 'SELECT * FROM Users WHERE email = :email AND role = "student"';
        $params = [':email' => $email];
        $result = $db->fetch($sql, $params);

        if ($result) {
            $student = new self($db);
            $student->hydrate($result);
            return $student;
        } else {
            return false;
        }
    }

    public static function all(Database $db) {
        $sql = 'SELECT * FROM Users WHERE role = "student"';
        $result = $db->fetchAll($sql);
        if ($result) {
            $students = [];
            foreach ($result as $student) {
                $t = new self($db);
                $t->hydrate($student);
                $teachers[] = $t;
            }
            return $students;
        } else {
            return false;
        }
    }
}
