<?php

<<<<<<< Updated upstream
namespace Core\Models;
=======
namespace App\Models;
>>>>>>> Stashed changes

use Helpers\Database;
use App\Models\Student;
use App\Models\Teacher;

class Course
{
    protected $db;
    protected $id;
    protected $title;
    protected $description;
    protected $teacher_id;
    protected $created_at;
    protected $updated_at;
    protected $is_published;
    protected $status;
    protected $category_id;


    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public static function create(Database $db, $title, $description, $teacher_id, $category_id, $is_published = false, $status = 'active')
    {
        $sql = 'INSERT INTO Courses (title, description, teacher_id, category_id, is_published, status) VALUES (:title, :description, :teacher_id, :category_id, :is_published, :status)';
        $params = [
            ':title' => $title,
            ':description' => $description,
            ':teacher_id' => $teacher_id,
            ':category_id' => $category_id,
            ':is_published' => $is_published,
            ':status' => $status
        ];
        if ($db->query($sql, $params)) {
            $id = $db->lastInsertId();
            return Course::loadById($db, $id);
        } else {
            return false;
        }
    }

    public static function loadById(Database $db, $id)
    {
        $sql = 'SELECT * FROM Courses WHERE id = :id';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);
<<<<<<< Updated upstream
        if ($result) {
=======
        if ($result !== false) {
>>>>>>> Stashed changes
            $course = new self($db);
            $course->hydrate($result);
            return $course;
        } else {
            return false;
        }
    }

    public function hydrate($data)
    {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->teacher_id = $data['teacher_id'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
        $this->is_published = $data['is_published'];
        $this->status = $data['status'];
        $this->category_id = $data['category_id'];
    }

    public static function all(Database $db)
    {
        $sql = 'SELECT * FROM Courses';
        $result = $db->fetchAll($sql);
<<<<<<< Updated upstream
        if ($result) {
=======
        if ($result !== false) {
>>>>>>> Stashed changes
            $courses = [];
            foreach ($result as $course) {
                $c = new self($db);
                $c->hydrate($course);
                $courses[] = $c;
            }
            return $courses;
        } else {
            return false;
        }
    }

    public static function allByTeacher(Database $db, $teacher_id)
    {
        $sql = 'SELECT * FROM Courses WHERE teacher_id = :teacher_id';
        $params = [':teacher_id' => $teacher_id];
        $result = $db->fetchAll($sql, $params);
<<<<<<< Updated upstream
        if ($result) {
=======
        if ($result !== false) {
>>>>>>> Stashed changes
            $courses = [];
            foreach ($result as $course) {
                $c = new self($db);
                $c->hydrate($course);
                $courses[] = $c;
            }
            return $courses;
        } else {
            return false;
        }
    }

<<<<<<< Updated upstream
    public static function allByStudent(Database $db, $student_id){
=======
    public static function allByStudent(Database $db, $student_id)
    {
>>>>>>> Stashed changes
        $sql = 'SELECT Courses.* from Courses
                JOIN Enrollments ON Courses.id = Enrollments.course_id
                WHERE Enrollments.student_id = :student_id';
        $params = [':student_id' => $student_id];
        $result = $db->fetchAll($sql, $params);
<<<<<<< Updated upstream
        if ($result) {
=======
        if ($result !== false) {
>>>>>>> Stashed changes
            $courses = [];
            foreach ($result as $course) {
                $c = new self($db);
                $c->hydrate($course);
                $courses[] = $c;
            }
            return $courses;
        } else {
            return false;
        }
    }

<<<<<<< Updated upstream
=======
    public static function allPublished(Database $db)
    {
        $sql = 'SELECT * FROM Courses WHERE is_published = true';
        $results = $db->fetchAll($sql);
        if ($results !== false) {
            $courses = [];
            foreach ($results as $data) {
                $course = new Course($db);
                $course->hydrate($data);
                $courses[] = $course;
            }
            return $courses;
        } else {
            return false;
        }
    }

>>>>>>> Stashed changes
    public function isPublished()
    {
        return $this->is_published;
    }

    public function publish()
    {
        $sql = 'UPDATE Courses SET is_published = true WHERE id = :id';
        $params = [':id' => $this->id];
        if ($this->db->query($sql, $params)) {
            $this->is_published = true;
            return true;
        } else {
            return false;
        }
    }

    public function unpublish()
    {
        $sql = 'UPDATE Courses SET is_published = false WHERE id = :id';
        $params = [':id' => $this->id];
        if ($this->db->query($sql, $params)) {
            $this->is_published = false;
            return true;
        } else {
            return false;
        }
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function activate()
    {
        $sql = 'UPDATE Courses SET status = "active" WHERE id = :id';
        $params = [':id' => $this->id];
        if ($this->db->query($sql, $params)) {
            $this->status = 'active';
            return true;
        } else {
            return false;
        }
    }

    public function deactivate()
    {
        $sql = 'UPDATE Courses SET status = "inactive" WHERE id = :id';
        $params = [':id' => $this->id];
        if ($this->db->query($sql, $params)) {
            $this->status = 'inactive';
            return true;
        } else {
            return false;
        }
    }

    function updateTitle($title)
    {
        $sql = 'UPDATE Courses SET title = :title WHERE id = :id';
        $params = [
            ':id' => $this->id,
            ':title' => $title
        ];
        if ($this->db->query($sql, $params)) {
            $this->title = $title;
            return true;
        } else {
            return false;
        }
    }

    function updatedescription($description)
    {
        $sql = 'UPDATE Courses SET description = :description WHERE id = :id';
        $params = [
            ':id' => $this->id,
            ':description' => $description
        ];
        if ($this->db->query($sql, $params)) {
            $this->description = $description;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getTeacherId()
    {
        return $this->teacher_id;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    public function getIsPublished()
    {
        return $this->is_published;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getCategoryId()
    {
        return $this->category_id;
    }
    public function getTeacher()
    {
        return Teacher::loadById($this->db, $this->teacher_id);
    }
    public function getEnrolledStudents()
    {
        return Student::allByCourse($this->db, $this->id);
    }
}
