<?php
namespace App\Controllers;

use Core\BaseController;
use Core\Auth;
use App\Models\Student;
use App\Models\Course;

class StudentController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        Auth::requireStudent();
    }

    private function loadStudent()
    {
        return Student::loadById($this->db, Auth::user()->getId());
    }
    public function dashboard()
    {
        $student = $this->loadStudent();
        $enrolledCourses = Course::allByStudent($this->db, $student->getId());

        return $this->render('student/dashboard', [
            'student' => $student,
            'courses' => $enrolledCourses
        ]);
    }



    public function enrollCourse($id)
    {
        $student = $this->loadStudent();
        $course = Course::loadById(new \Helpers\Database(), $id);

        if (!$course || !$course->isPublished()) {
            $this->setFlash('enrollment', 'Course not available');
            header('Location: /student/courses');
            exit;
        }

        //enrollment logic mzl mdrtihaash asi mhmd

        header('Location: /student/enrollments/' . $course->getId());
        exit;
    }
}
