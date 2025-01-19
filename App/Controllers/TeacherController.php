<?php

namespace App\Controllers;

use App\Models\Category;
use Core\BaseController;
use Core\Auth;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Document;
use App\Models\Tag;
use App\Models\Thumbnail;
use App\Models\Video;

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

    public function pending()
    {
        $this->render('teacher/pending');
    }

    public function createCoursePage()
    {
        $categories = Category::all($this->db);
        $tags = Tag::all($this->db);

        $this->render('teacher/courses/create', [
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function createCourse()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // echo '<pre>';
            // echo var_dump($_POST);
            // echo 'files';
            // echo var_dump($_FILES);
            // echo '</pre>';
            // die();

            $contentType = $_POST['content_type'] ?? null;
            $courseTitle = $_POST['course_title'] ?? null;
            $courseDescription = $_POST['course_description'] ?? null;
            $thumbnail = $_FILES['thumbnail'] ?? null;
            $contentTitle = $_POST['content_title'] ?? null;
            $contentDescription = $_POST['content_description'] ?? null;
            $contentFile = $_FILES['content_file'] ?? null;
            $categoryId = $_POST['category_id'] ?? null;
            $tags = $_POST['tags'] ?? null;

            if (!$contentType) {
                $this->setFlash('/teacher/courses/create', 'Content type is required', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            if (!$courseTitle){
                $this->setFlash('/teacher/courses/create', 'Course title is required', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            if (!$courseDescription){
                $this->setFlash('/teacher/courses/create', 'Course description is required', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }
            if ($categoryId === null) {
                $this->setFlash('/teacher/courses/create', 'Category is required', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            if (!Category::loadById($this->db, $categoryId)) {
                $this->setFlash('/teacher/courses/create', 'Invalid category', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            if ($tags === null){
                $this->setFlash('/teacher/courses/create', 'Tags are required (at least one)', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            if (!$tags) {
                $this->setFlash('/teacher/courses/create', 'Tags are required (at least one)', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            $tags = explode(',', $tags);
            $tags = array_map('trim', $tags);

            foreach($tags as $tag){
                $tag = Tag::loadById($this->db, $tag);
                if(!$tag){
                    $this->setFlash('/teacher/courses/create', 'Invalid tag', 'error');
                    header('Location: /teacher/courses/create');
                    exit;
                }
            }

            if (count($tags) > 10) {
                $this->setFlash('/teacher/courses/create', 'Maximum of 10 tags allowed', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            if (count($tags) < 1) {
                $this->setFlash('/teacher/courses/create', 'At least one tag is required', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            if (!$thumbnail) {
                $this->setFlash('/teacher/courses/create', 'Thumbnail is required', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            if (!$contentTitle) {
                $this->setFlash('/teacher/courses/create', 'Content title is required', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            if (!$contentDescription) {
                $this->setFlash('/teacher/courses/create', 'Content description is required', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            if (!$contentFile) {
                $this->setFlash('/teacher/courses/create', 'Content file is required', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            if ($contentType === 'document') {
                if (!Document::validateType($contentFile)) {
                    $this->setFlash('/teacher/courses/create', 'Invalid document type', 'error');
                    header('Location: /teacher/courses/create');
                    exit;
                }
                if (!Document::validateSize($contentFile)) {
                    $this->setFlash('/teacher/courses/create', 'Invalid document size', 'error');
                    header('Location: /teacher/courses/create');
                    exit;
                }
            } elseif ($contentType === 'video') {
                if (!Video::validateType($contentFile)) {
                    $this->setFlash('/teacher/courses/create', 'Invalid video type', 'error');
                    header('Location: /teacher/courses/create');
                    exit;
                }
                if (!Video::validateSize($contentFile)) {
                    $this->setFlash('/teacher/courses/create', 'Invalid video size', 'error');
                    header('Location: /teacher/courses/create');
                    exit;
                }
            } else {
                $this->setFlash('/teacher/courses/create', 'Invalid content type', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            $course = Course::create($this->db, $courseTitle, $courseDescription, $this->teacher->getId(), $categoryId);

            if (!$course) {
                $this->setFlash('/teacher/courses/create', 'Failed to create course', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            foreach ($tags as $tagId) {
                if (!$course->addTag($tagId)) {
                    $this->setFlash('/teacher/courses/create', 'Failed to add tag', 'error');
                    header('Location: /teacher/courses/create');
                    exit;
                }
            }
            if (!Thumbnail::validateTypr($thumbnail)) {
                $this->setFlash('/teacher/courses/create', 'Invalid thumbnail type', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            if (!Thumbnail::validateSize($thumbnail)) {
                $this->setFlash('/teacher/courses/create', 'Invalid thumbnail file size', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            $thumbnailPath = Thumbnail::upload($thumbnail);
            if (!$thumbnailPath) {
                $this->setFlash('/teacher/courses/create', 'Failed to upload thumbnail', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            $course = Course::create($this->db, $courseTitle, $courseDescription, $this->teacher->getId(), $categoryId);
            if (!$course) {
                $this->setFlash('/teacher/courses/create', 'Failed to create course', 'error');
                header('Location: /teacher/courses/create');
                exit;
            }

            if ($contentType === 'document') {
                $contentPath = Document::upload($contentFile);
                if (!$contentPath) {
                    $this->setFlash('/teacher/courses/create', 'Failed to upload document', 'error');
                    header('Location: /teacher/courses/create');
                    exit;
                }
                $content = Document::create($this->db, $course->getId(), $contentPath, $contentFile['size'], pathinfo($contentFile['name'], PATHINFO_EXTENSION), $contentTitle, $contentDescription);
                if (!$content) {
                    $this->setFlash('/teacher/courses/create', 'Failed to create document', 'error');
                    header('Location: /teacher/courses/create');
                    exit;
                }

            } elseif ($contentType === 'video') {
                $contentPath = Video::upload($contentFile);
                if (!$contentPath) {
                    $this->setFlash('/teacher/courses/create', 'Failed to upload video', 'error');
                    header('Location: /teacher/courses/create');
                    exit;
                }
                $content = Video::create($this->db, $course->getId(), $contentPath, 1450, $contentTitle, $contentDescription);
                if (!$content) {
                    $this->setFlash('/teacher/courses/create', 'Failed to create video', 'error');
                    header('Location: /teacher/courses/create');
                    exit;
                }
            }

            $this->setFlash('/teacher/courses/create', 'Course created successfully', 'success');
            header('Location: /teacher/courses/create');
            exit;
        }
    }
}
