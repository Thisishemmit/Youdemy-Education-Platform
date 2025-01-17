<?php

namespace App\Controllers;

use Core\Auth;
use Core\BaseController;
use App\Models\Course;

class CourseController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function viewCourse($id)
    {
        $course = Course::loadById($this->db, $id);

        if (!$course || !$course->isPublished()) {
            header('Location: /student/courses');
            exit;
        }

        return $this->render('student/view-course', [
            'course' => $course
        ]);
    }

    public function courses()
    {
        $teacher = Auth::user();
        $courses = Course::allByTeacher($this->db, $teacher->getId());

        return $this->render('/courses', [
            'courses' => $courses
        ]);
    }
}
