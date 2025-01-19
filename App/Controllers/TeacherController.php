<?php
namespace App\Controllers;

use Core\BaseController;
use Core\Auth;
use App\Models\Teacher;
use App\Models\Course;

class TeacherController extends BaseController
{
    private $teacher;
    public function __construct()
    {
        parent::__construct();
        Auth::requireTeacher();
        $this->teacher = $this->loadTeacher();
    }



    private function loadTeacher()
    {
        return Teacher::loadById($this->db, Auth::user()->getId());
    }
    public function dashboard()
    {
        if (!$this->teacher->isVerified()) {
            header('Location: /teacher/pending');
            exit;
        }

        $courses = Course::allByTeacher($this->db, $this->teacher->getId());

        return $this->render('teacher/dashboard', [
            'teacher' => $this->teacher,
            'courses' => $courses
        ]);
    }

    public function pending(){
        $this->render('teacher/pending');
    }

    public function createCoursePage(){
        $this->render('teacher/courses/create');
    }
    public function createCourse()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }
}
