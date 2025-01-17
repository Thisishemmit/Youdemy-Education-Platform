<?php
namespace App\Models;
use Helpers\Database;
use App\Models\User;

class Teacher extends User {
    public function __construct(Database $db) {
        parent::__construct($db);
        $this->role = 'teacher';
    }

    public static function create(Database $db, $username, $email, $password, $role = 'teacher', $status = 'pending') {
        return User::create($db, $username, $email, $password, $role, $status);
    }
    public function isPending() {
        return $this->status === 'pending';
    }

    public function isActive() {
        return $this->status === 'active';
    }

    public function isSuspended() {
        return $this->status === 'suspended';
    }

    public function isRejected() {
        return $this->status === 'rejected';
    }

    public function isVerified() {
        return !$this->isPending() && !$this->isRejected();
    }

    public function canBeActivated() {
        return $this->isVerified() && $this->isSuspended();
    }

    public function canBeSuspended() {
        return $this->isVerified() && $this->isActive();
    }

    public function canBeVerified() {
        return $this->isPending();
    }

    public function canBeRejected() {
        return $this->isPending();
    }

    public function verify() {
        if ($this->canBeVerified()) {
            return $this->updateStatus('active');
        }
        return false;
    }

    public function reject() {
        if ($this->canBeRejected()) {
            return $this->updateStatus('rejected');
        }
        return false;
    }

    public function suspend() {
        if ($this->canBeSuspended()) {
            return $this->updateStatus('suspended');
        }
        return false;
    }

    public function activate() {
        if ($this->canBeActivated()) {
            return $this->updateStatus('active');
        }
        return false;
    }

    public function updateStatus($status) {
        $validStatuses = ['pending', 'active', 'suspended', 'rejected'];
        if (!in_array($status, $validStatuses)) {
            return false;
        }

        $sql = 'UPDATE Users SET status = :status WHERE id = :id AND role = "teacher"';
        $params = [
            ':id' => $this->id,
            ':status' => $status
        ];
        if ($this->db->query($sql, $params)) {
            $this->status = $status;
            return true;
        }
        return false;
    }

    public function hasCourses() {
        $sql = 'SELECT COUNT(*) FROM Courses WHERE teacher_id = :teacher_id';
        $params = [':teacher_id' => $this->id];
        return $this->db->fetch($sql, $params)['COUNT(*)'] > 0;
    }

    public static function loadById(Database $db, $id) {
        $sql = 'SELECT * FROM Users WHERE id = :id AND role = "teacher"';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);
        if ($result !== false) {
            $teacher = new self($db);
            $teacher->hydrate($result);
            return $teacher;
        }
        return false;
    }

    public static function loadByEmail(Database $db, $email) {
        $sql = 'SELECT * FROM Users WHERE email = :email AND role = "teacher"';
        $params = [':email' => $email];
        $result = $db->fetch($sql, $params);

        if ($result !== false) {
            $teacher = new self($db);
            $teacher->hydrate($result);
            return $teacher;
        }
        return false;
    }

    public static function all(Database $db) {
        $sql = 'SELECT * FROM Users WHERE role = "teacher"';
        $result = $db->fetchAll($sql);
        if ($result !== false) {
            $teachers = [];
            foreach ($result as $teacher) {
                $t = new self($db);
                $t->hydrate($teacher);
                $teachers[] = $t;
            }
            return $teachers;
        }
        return false;
    }

    public static function countByStatus(Database $db, $status) {
        $sql = 'SELECT COUNT(*) FROM Users WHERE role = "teacher" AND status = :status';
        $params = [':status' => $status];
        $result = $db->fetch($sql, $params);
        if ($result !== false) {
            return $result['COUNT(*)'];
        }
        return false;
    }

    public static function count(Database $db) {
        $sql = 'SELECT COUNT(*) FROM Users WHERE role = "teacher"';
        $result = $db->fetch($sql);
        if ($result !== false) {
            return $result['COUNT(*)'];
        }
        return false;
    }

    public static function allByStatus(Database $db, $status) {
        $sql = 'SELECT * FROM Users WHERE role = "teacher" AND status = :status';
        $params = [':status' => $status];
        $result = $db->fetchAll($sql, $params);
        if ($result !== false) {
            $teachers = [];
            foreach ($result as $teacher) {
                $t = new self($db);
                $t->hydrate($teacher);
                $teachers[] = $t;
            }
            return $teachers;
        }
        return false;
    }
}
