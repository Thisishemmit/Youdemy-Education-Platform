<?php
namespace App\Models;
use Helpers\Database;
use App\Models\User;

class Teacher extends User {
    public function __construct(Database $db) {
        parent::__construct($db);
    }

    public static function create(Database $db, $username, $email, $password, $role = 'teacher', $status = 'pending') {
        return User::create($db, $username, $email, $password, $role, $status);
    }

    public function isVerified() {
        return $this->status === 'active';
    }


    public function verify() {
        if ($this->status === 'pending') {
            if ($this->updateStatus('active')) {
                $this->status = 'active';
                return true;
            }
        } else {
            return false;
        }
    }

    public function hasCourses() {
        $sql = 'SELECT COUNT(*) FROM Courses WHERE teacher_id = :teacher_id';
        $params = [':teacher_id' => $this->id];
        $result = $this->db->fetch($sql, $params);
        return $result[0] > 0;
    }

    public static function loadById(Database $db, $id) {
        $sql = 'SELECT * FROM Users WHERE id = :id AND role = "teacher"';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);
        if ($result) {
            $teacher = new self($db);
            $teacher->hydrate($result);
            return $teacher;
        } else {
            return false;
        }
    }

    public static function loadByEmail(Database $db, $email) {

        $sql = 'SELECT * FROM Users WHERE email = :email AND role = "teacher"';
        $params = [':email' => $email];
        $result = $db->fetch($sql, $params);

        if ($result) {
            $teacher = new self($db);
            $teacher->hydrate($result);
            return $teacher;
        } else {
            return false;
        }
    }

    public static function all(Database $db) {
        $sql = 'SELECT * FROM Users WHERE role = "teacher"';
        $result = $db->fetchAll($sql);
        if ($result) {
            $teachers = [];
            foreach ($result as $teacher) {
                $t = new self($db);
                $t->hydrate($teacher);
                $teachers[] = $t;
            }
            return $teachers;
        } else {
            return false;
        }
    }
}


