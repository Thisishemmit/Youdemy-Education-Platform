<?php

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\CourseController;
use App\Controllers\HomeController;
use App\Controllers\StudentController;
use App\Controllers\TeacherController;
use App\Models\User;
use Core\Route;
use Core\Router;
use Helpers\Database;

session_start();
include '../Helpers/autoload.php';

$db = new Database();
$db->connect();
if (User::count($db) == 0) {
    User::create($db, 'admin', 'mkaroumi123@gmail.com', '123123', 'admin', 'active');
}

$router = new Router();
Route::setRouter($router);

Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);

// AUTH AUTH AUTH
Route::get('/login', [AuthController::class, 'loginPage']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerPage']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/logout', [AuthController::class, 'logout']);

// ADMIN ADMIN
Route::get('/admin', [AdminController::class, 'dashboard']);
Route::get('/admin/teachers', [AdminController::class, 'teachers']);
Route::get('/admin/teachers/pending', [AdminController::class, 'pendingTeachers']);
Route::post('/admin/teachers/verify', [AdminController::class, 'verifyTeacher']);
Route::post('/admin/teachers/suspend', [AdminController::class, 'suspendTeacher']);
Route::post('/admin/teachers/reject', [AdminController::class, 'rejectTeacher']);
Route::post('/admin/teachers/activate', [AdminController::class, 'activateTeacher']);

Route::get('/admin/categories', [AdminController::class, 'categories']);
Route::post('/admin/categories/create', [AdminController::class, 'createCategory']);
Route::post('/admin/categories/delete', [AdminController::class, 'deleteCategory']);
Route::get('/admin/tags', [AdminController::class, 'tags']);
Route::post('/admin/tags/create', [AdminController::class, 'createTag']);
Route::post('/admin/tags/delete', [AdminController::class, 'deleteTag']);

Route::get('/admin/students', [AdminController::class, 'students']);
Route::post('/admin/students/suspend', [AdminController::class, 'suspendStudent']);
Route::post('/admin/students/activate', [AdminController::class, 'activateStudent']);

Route::get('/admin/students/{id}/edit', [AdminController::class, 'editStudent']);
Route::post('/admin/students/{id}/edit', [AdminController::class, 'editStudent']);
Route::post('/admin/students/{id}/delete', [AdminController::class, 'deleteStudent']);
Route::get('/admin/courses', [AdminController::class, 'courses']);
Route::post('/admin/courses/{id}/toggle-status', [AdminController::class, 'toggleCourseStatus']);

// COURSE COURSE
Route::get('/courses', [CourseController::class, 'courses']);
Route::get('/courses/{id}', [CourseController::class, 'viewCourse']);
Route::post('/courses/{id}/enroll', [CourseController::class, 'enroll']);

Route::get('/teacher', [TeacherController::class, 'dashboard']);
Route::get('/teacher/courses', [TeacherController::class, 'courses']);
Route::get('/teacher/courses/create', [TeacherController::class, 'createCoursePage']);
Route::post('/teacher/courses/create', [TeacherController::class, 'createCourse']);
Route::get('/teacher/pending', [TeacherController::class, 'pending']);
Route::get('/teacher/courses/{id}/edit', [TeacherController::class, 'editCoursePage']);
Route::post('/teacher/courses/{id}/edit', [TeacherController::class, 'updateCourse']);
Route::post('/teacher/courses/{id}/publish', [TeacherController::class, 'publishCourse']);
Route::post('/teacher/courses/{id}/unpublish', [TeacherController::class, 'unpublishCourse']);
Route::post('/teacher/courses/delete', [TeacherController::class, 'deleteCourse']); 
Route::get('/teacher/analytics', [TeacherController::class, 'statistics']);

Route::get('/student', [StudentController::class, 'dashboard']);
Route::get('/student/courses', [StudentController::class, 'courses']);
Route::get('/student/courses/{id}', [StudentController::class, 'viewCourse']);
Route::post('/student/courses/{id}/complete', [StudentController::class, 'completeEnrollment']);
Route::post('/student/courses/{id}/drop', [StudentController::class, 'dropCourse']);

Route::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
