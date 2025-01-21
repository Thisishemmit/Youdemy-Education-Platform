<?php

namespace App\Models;

use Helpers\Database;

class Enrollment
{
    private $db;
    private $id;
    private $studentId;
    private $courseId;
    private $created_at;
    private $updated_at;
    private $completed_at;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStudentId()
    {
        return $this->studentId;
    }

    public function getCourseId()
    {
        return $this->courseId;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getCompletedAt()
    {
        return $this->completed_at;
    }

    public function hydrate($data)
    {
        $this->id = $data['id'];
        $this->studentId = $data['student_id'];
        $this->courseId = $data['course_id'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
        $this->completed_at = $data['completion_date'];
    }
    // CREATE TABLE IF NOT EXISTS Enrollments (
    //     id INT AUTO_INCREMENT PRIMARY KEY,
    //     student_id INT NOT NULL,
    //     course_id INT NOT NULL,
    //     completion_date TIMESTAMP NULL,
    //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    //     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    //     FOREIGN KEY(student_id) REFERENCES Users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    //     FOREIGN KEY(course_id) REFERENCES Courses(id) ON DELETE CASCADE ON UPDATE CASCADE
    // );


    public static function loadById(Database $db, $id)
    {
        $sql = 'SELECT * FROM Enrollments WHERE id = :id';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);
        if ($result !== false) {
            $enrollment = new self($db);
            $enrollment->hydrate($result);
            return $enrollment;
        }
        return false;
    }

    public static function all(Database $db)
    {
        $sql = 'SELECT * FROM Enrollments';
        $result = $db->fetchAll($sql);
        if ($result !== false) {
            $enrollments = [];
            foreach ($result as $enrollment) {
                $e = new self($db);
                $e->hydrate($enrollment);
                $enrollments[] = $e;
            }
            return $enrollments;
        } else {
            return false;
        }
    }

    public static function allByStudent(Database $db, $student_id)
    {
        $sql = 'SELECT * FROM Enrollments WHERE student_id = :student_id';
        $params = [':student_id' => $student_id];
        $result = $db->fetchAll($sql, $params);
        if ($result !== false) {
            $enrollments = [];
            foreach ($result as $enrollment) {
                $e = new self($db);
                $e->hydrate($enrollment);
                $enrollments[] = $e;
            }
            return $enrollments;
        } else {
            return false;
        }
    }

    public static function allByCourse(Database $db, $course_id)
    {
        $sql = 'SELECT * FROM Enrollments WHERE course_id = :course_id';
        $params = [':course_id' => $course_id];
        $result = $db->fetchAll($sql, $params);
        if ($result !== false) {
            $enrollments = [];
            foreach ($result as $enrollment) {
                $e = new self($db);
                $e->hydrate($enrollment);
                $enrollments[] = $e;
            }
            return $enrollments;
        } else {
            return false;
        }
    }

    public static function enroll(Database $db, $student_id, $course_id)
    {
        $sql = 'INSERT INTO Enrollments (student_id, course_id) VALUES (:student_id, :course_id)';
        $params = [':student_id' => $student_id, ':course_id' => $course_id];
        return $db->query($sql, $params);
    }

    public static function loadByStudentAndCourse(Database $db, $student_id, $course_id)
    {
        $sql = 'SELECT * FROM Enrollments WHERE student_id = :student_id AND course_id = :course_id';
        $params = [':student_id' => $student_id, ':course_id' => $course_id];
        $result = $db->fetch($sql, $params);
        if ($result !== false) {
            $enrollment = new self($db);
            $enrollment->hydrate($result);
            return $enrollment;
        }
        return false;
    }

    public static function isComplete(Database $db, $student_id, $course_id)
    {
        $sql = 'SELECT * FROM Enrollments WHERE student_id = :student_id AND course_id = :course_id AND completion_date IS NOT NULL';
        $params = [':student_id' => $student_id, ':course_id' => $course_id];
        $result = $db->fetch($sql, $params);
        return $result !== false;
    }

    public static function complete(Database $db, $student_id, $course_id)
    {
        $sql = 'UPDATE Enrollments SET completion_date = CURRENT_TIMESTAMP WHERE student_id = :student_id AND course_id = :course_id';
        $params = [':student_id' => $student_id, ':course_id' => $course_id];
        return $db->query($sql, $params);
    }

    public static function delete(Database $db, $student_id, $course_id)
    {
        $sql = 'DELETE FROM Enrollments WHERE student_id = :student_id AND course_id = :course_id';
        $params = [':student_id' => $student_id, ':course_id' => $course_id];
        return $db->query($sql, $params);
    }


}
