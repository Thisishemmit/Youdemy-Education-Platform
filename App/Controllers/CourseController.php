<?php

namespace App\Controllers;

use Core\Auth;
use Core\BaseController;
use App\Models\Course;
use App\Models\Document;
use App\Models\Student;
use App\Models\Video;

class CourseController extends BaseController
{
    private $itemsPerPage = 6;
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
        $contents = array_merge(
            Video::allByCourseId($this->db, $course->getId()) ?: [],
            Document::allByCourseId($this->db, $course->getId()) ?: []
        );
        return $this->render('courses/view', ['course' => $course, 'contents' => $contents]);
    }

    public function courses()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $this->itemsPerPage;

        $totalCourses = Course::countPublished($this->db);
        $totalPages = ceil($totalCourses / $this->itemsPerPage);

        $courses = Course::allPublishedPaginated($this->db, $this->itemsPerPage, $offset);

        return $this->render('courses/index', [
            'courses' => $courses,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function enroll($id)
    {
        Auth::requireStudent();
        $course = Course::loadById($this->db, $id);
        if (!$course || !$course->isPublished()) {
            header('Location: /courses');
            exit;
        }
        $student = Auth::user()->getId();
        $student = Student::loadById($this->db, $student);
        $rslt = $student->enroll($course->getId());
        if ($rslt) {
            $this->setFlash('/student/courses', 'You have successfully enrolled in the course', 'success');
            header('Location: /student/courses');
            exit;
        } else {
            $this->setFlash('/courses/enroll', 'You are already enrolled in this course', 'error');
            header("Location: /courses/{$id}");
            exit;
        }
    }
}
