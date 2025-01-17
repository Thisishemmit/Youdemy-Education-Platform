<?php
namespace App\Controllers;

use Core\BaseController;
use Core\Auth;
use App\Models\Course;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->getRole() === 'admin') {
                header('Location: /admin/dashboard');
                exit;
            } elseif (Auth::user()->getRole() === 'teacher') {
                header('Location: /teacher');
                exit;
            } else {
                header('Location: /student');
                exit;
            }
        }
        return $this->render('public/landing');
    }

    public function courses()
    {
        $courses = Course::allPublished($this->db);

        return $this->render('/courses', [
            'courses' => $courses
        ]);
    }
}
