<?php

namespace App\Controllers;

use Core\BaseController;
use Core\Auth;
use App\Models\Teacher;
use App\Models\Category;
use App\Models\Tag;

class AdminController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        Auth::requireAdmin();
    }

    public function dashboard()
    {
        return $this->render('admin/dashboard');
    }

    public function teachers()
    {
        $teachers = Teacher::all($this->db);
        $pendingCount = Teacher::countByStatus($this->db, 'pending');
        return $this->render('admin/teachers', [
            'teachers' => $teachers,
            'pendingCount' => $pendingCount
        ]);
    }

    public function pendingTeachers()
    {
        $teachers = Teacher::allByStatus($this->db, 'pending');
        $hasPendingTeachers = Teacher::countByStatus($this->db, 'pending') > 0;
        return $this->render('admin/pending_teachers', [
            'teachers' => $teachers,
            'hasPendingTeachers' => $hasPendingTeachers
        ]);
    }

    public function activateTeacher()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $teacherId = $_POST['teacher_id'] ?? null;
            if ($teacherId) {
                $teacher = Teacher::loadById($this->db, $teacherId);
                if ($teacher) {
                    if ($teacher->canBeActivated()) {
                        if ($teacher->activate()) {
                            $this->setFlash('/admin/teachers', 'Teacher activated successfully', 'success');
                        } else {
                            $this->setFlash('/admin/teachers', 'Failed to activate teacher', 'error');
                        }
                    } else {
                        $this->setFlash('/admin/teachers', 'Teacher cannot be activated in their current status', 'error');
                    }
                } else {
                    $this->setFlash('/admin/teachers', 'Teacher not found', 'error');
                }
            }
        }
        header('Location: /admin/teachers');
        exit;
    }

    public function verifyTeacher()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $teacherId = $_POST['teacher_id'] ?? null;
            if ($teacherId) {
                $teacher = Teacher::loadById($this->db, $teacherId);
                if ($teacher) {
                    if ($teacher->canBeVerified()) {
                        if ($teacher->verify()) {
                            $this->setFlash('/admin/teachers/pending', 'Teacher verified successfully', 'success');
                        } else {
                            $this->setFlash('/admin/teachers/pending', 'Failed to verify teacher', 'error');
                        }
                    } else {
                        $this->setFlash('/admin/teachers/pending', 'Teacher cannot be verified in their current status', 'error');
                    }
                } else {
                    $this->setFlash('/admin/teachers/pending', 'Teacher not found', 'error');
                }
            }
        }
        header('Location: /admin/teachers/pending');
        exit;
    }

    public function suspendTeacher()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $teacherId = $_POST['teacher_id'] ?? null;
            if ($teacherId) {
                $teacher = Teacher::loadById($this->db, $teacherId);
                if ($teacher) {
                    if ($teacher->canBeSuspended()) {
                        if ($teacher->suspend()) {
                            $this->setFlash('/admin/teachers', 'Teacher suspended successfully', 'success');
                        } else {
                            $this->setFlash('/admin/teachers', 'Failed to suspend teacher', 'error');
                        }
                    } else {
                        $this->setFlash('/admin/teachers', 'Teacher cannot be suspended in their current status', 'error');
                    }
                } else {
                    $this->setFlash('/admin/teachers', 'Teacher not found', 'error');
                }
            }
        }
        header('Location: /admin/teachers');
        exit;
    }

    public function rejectTeacher()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $teacherId = $_POST['teacher_id'] ?? null;
            if ($teacherId) {
                $teacher = Teacher::loadById($this->db, $teacherId);
                if ($teacher) {
                    if ($teacher->canBeRejected()) {
                        if ($teacher->reject()) {
                            $this->setFlash('/admin/teachers/pending', 'Teacher application rejected successfully', 'success');
                        } else {
                            $this->setFlash('/admin/teachers/pending', 'Failed to reject teacher application', 'error');
                        }
                    } else {
                        $this->setFlash('/admin/teachers/pending', 'Teacher application cannot be rejected in their current status', 'error');
                    }
                } else {
                    $this->setFlash('/admin/teachers/pending', 'Teacher not found', 'error');
                }
            }
        }
        header('Location: /admin/teachers/pending');
        exit;
    }

    public function categories()
    {
        $categories = Category::all($this->db);
        return $this->render('admin/categories', [
            'categories' => $categories
        ]);
    }

    public function createCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($name)) {
                $this->setFlash('/admin/categories', 'Category name is required', 'error');
            } elseif (Category::exists($this->db, $name)) {
                $this->setFlash('/admin/categories', 'A category with this name already exists', 'error');
            } else {
                $category = Category::create($this->db, $name, $description);
                if ($category) {
                    $this->setFlash('/admin/categories', 'Category created successfully', 'success');
                } else {
                    $this->setFlash('/admin/categories', 'Failed to create category', 'error');
                }
            }
        }
        header('Location: /admin/categories');
        exit;
    }

    public function deleteCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryId = $_POST['category_id'] ?? null;
            if ($categoryId) {
                $category = Category::loadById($this->db, $categoryId);
                if ($category && $category->delete()) {
                    $this->setFlash('/admin/categories', 'Category deleted successfully', 'success');
                } else {
                    $this->setFlash('/admin/categories', 'Failed to delete category', 'error');
                }
            }
        }
        header('Location: /admin/categories');
        exit;
    }

    public function tags()
    {
        $tags = Tag::all($this->db);
        return $this->render('admin/tags', [
            'tags' => $tags
        ]);
    }

    public function createTag()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');

            if (empty($name)) {
                $this->setFlash('/admin/tags', 'Tag name is required', 'error');
            } elseif (Tag::exists($this->db, $name)) {
                $this->setFlash('/admin/tags', 'A tag with this name already exists', 'error');
            } else {
                $tag = Tag::create($this->db, $name);
                if ($tag) {
                    $this->setFlash('/admin/tags', 'Tag created successfully', 'success');
                } else {
                    $this->setFlash('/admin/tags', 'Failed to create tag', 'error');
                }
            }
        }
        header('Location: /admin/tags');
        exit;
    }

    public function deleteTag()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tagId = $_POST['tag_id'] ?? null;
            if ($tagId) {
                $tag = Tag::loadById($this->db, $tagId);
                if ($tag && $tag->delete()) {
                    $this->setFlash('/admin/tags', 'Tag deleted successfully', 'success');
                } else {
                    $this->setFlash('/admin/tags', 'Failed to delete tag', 'error');
                }
            }
        }
        header('Location: /admin/tags');
        exit;
    }

    public function test()
    {
        return $this->render('admin/test');
    }
}
