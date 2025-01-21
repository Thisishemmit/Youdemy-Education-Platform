<?php

namespace App\Controllers;

use Core\BaseController;
use Core\Auth;
use App\Models\Student;
use App\Models\Course;
use App\Models\Document;
use App\Models\Video;

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
        $course = Course::loadById($this->db, $id);

        if (!$course || !$course->isPublished()) {
            $this->setFlash('enrollment', 'Course not available');
            header('Location: /student/courses');
            exit;
        }


        header('Location: /student/enrollments/' . $course->getId());
        exit;
    }

    public function courses()
    {
        $student = $this->loadStudent();
        $enrolledCourses = Course::allByStudent($this->db, $student->getId());
        $this->render('student/courses', [
            'courses' => $enrolledCourses,
            'student' => $student
        ]);
    }

    public function viewCourse($id)
    {
        $student = $this->loadStudent();
        $course = Course::loadById($this->db, $id);

        // Verify enrollment
        if (!$course || !$course->isStudentEnrolled($student->getId())) {
            header('Location: /student/courses');
            exit;
        }

        $contents = array_merge(
            Video::allByCourseId($this->db, $course->getId()) ?: [],
            Document::allByCourseId($this->db, $course->getId()) ?: []
        );

        return $this->render('student/courses/view', [
            'course' => $course,
            'content' => $contents[0] ?? null,
            'student' => $student
        ]);
    }

    public function completeEnrollment($course_id)
    {
        $student = $this->loadStudent();
        $course = Course::loadById($this->db, $course_id);

        if (!$course || !$course->isStudentEnrolled($student->getId()) || $this->loadStudent()->isCompleted($course_id)) {
            header('Location: /student/courses');
            exit;
        }

        $student->completeEnrollment($course_id);
        header('Location: /student/courses');
        exit;
    }

    public function dropCourse($course_id)
    {
        $student = $this->loadStudent();
        $course = Course::loadById($this->db, $course_id);

        if (!$course || !$course->isStudentEnrolled($student->getId())) {
            header('Location: /student/courses');
            exit;
        }

        $student->dropCourse($course_id);
        header('Location: /student/courses');
        exit;
    }
}
