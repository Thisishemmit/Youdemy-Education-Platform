<?php

namespace App\Models;

use Helpers\Database;
use App\Models\User;

class Student extends User
{
    public function __construct(Database $db)
    {
        parent::__construct($db);
    }

    public static function create(Database $db, $username, $email, $password, $role = 'student', $status = 'active')
    {
        return User::create($db, $username, $email, $password, $role, $status);
    }

    public static function loadById(Database $db, $id)
    {
        $sql = 'SELECT * FROM Users WHERE id = :id AND role = "student"';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);
        if ($result !== false) {
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

        if ($result !== false) {
            $student = new self($db);
            $student->hydrate($result);
            return $student;
        } else {
            return false;
        }
    }

    public static function all(Database $db)
    {
        $sql = 'SELECT * FROM Users WHERE role = "student"';
        $result = $db->fetchAll($sql);

        if ($result !== false) {
            $students = [];
            foreach ($result as $student) {
                $t = new self($db);
                $t->hydrate($student);
                $students[] = $t;
            }
            return $students;
        } else {
            return false;
        }
    }

    public static function allByCourse(Database $db, $course_id)
    {
        $sql = 'SELECT Users.* from Users
                JOIN Enrollments ON Users.id = Enrollments.student_id
                WHERE Enrollments.course_id = :course_id';
        $params = [':course_id' => $course_id];
        $result = $db->fetchAll($sql, $params);

        if ($result !== false) {
            $students = [];
            foreach ($result as $student) {
                $t = new self($db);
                $t->hydrate($student);
                $students[] = $t;
            }
            return $students;
        } else {
            return false;
        }
    }

    public static function allByTeacher(Database $db, $teacher_id)
    {
        $sql = 'SELECT Users.* from Users
                JOIN Enrollments ON Users.id = Enrollments.student_id
                JOIN Courses ON Courses.id = Enrollments.course_id
                WHERE Courses.teacher_id = :teacher_id AND Users.role = "student"';
        $params = [':teacher_id' => $teacher_id];
        $result = $db->fetchAll($sql, $params);

        if ($result !== false) {
            $students = [];
            foreach ($result as $student) {
                $t = new self($db);
                $t->hydrate($student);
                $students[] = $t;
            }
            return $students;
        } else {
            return false;
        }
    }

    public function enroll($course_id)
    {
        $sql = 'INSERT INTO Enrollments (student_id, course_id) VALUES (:student_id, :course_id)';
        $params = [':student_id' => $this->id, ':course_id' => $course_id];
        return $this->db->query($sql, $params);
    }
    public function completeEnrollment($course_id)
    {
        return Enrollment::complete($this->db, $this->id, $course_id);
    }

    public function isCompleted($course_id)
    {
        return Enrollment::isComplete($this->db, $this->id, $course_id);
    }

    public function dropCourse($course_id)
    {
        return Enrollment::delete($this->db, $this->id, $course_id);
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

    public function canBeActivated() {
        return $this->isSuspended();
    }

    public function canBeSuspended() {
        return $this->isActive();
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
        $validStatuses = ['active', 'suspended'];
        if (!in_array($status, $validStatuses)) {
            return false;
        }

        $sql = 'UPDATE Users SET status = :status WHERE id = :id AND role = "student"';
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
}
