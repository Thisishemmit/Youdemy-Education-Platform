<?php

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\CourseController;
use App\Controllers\HomeController;
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
Route::get('/logout', [AuthController::class, 'logout']);

// ADMIN ADMIN
Route::get('/admin', [AdminController::class, 'dashboard']);
Route::get('/admin/teachers', [AdminController::class, 'teachers']);
Route::get('/admin/teachers/pending', [AdminController::class, 'pendingTeachers']);
Route::post('/admin/teachers/verify', [AdminController::class, 'verifyTeacher']);
Route::post('/admin/teachers/suspend', [AdminController::class, 'suspendTeacher']);
Route::post('/admin/teachers/reject', [AdminController::class, 'rejectTeacher']);
Route::post('/admin/teachers/activate', [AdminController::class, 'activateTeacher']);

// Categories and Tags Management
Route::get('/admin/categories', [AdminController::class, 'categories']);
Route::post('/admin/categories/create', [AdminController::class, 'createCategory']);
Route::post('/admin/categories/delete', [AdminController::class, 'deleteCategory']);
Route::get('/admin/tags', [AdminController::class, 'tags']);
Route::post('/admin/tags/create', [AdminController::class, 'createTag']);
Route::post('/admin/tags/delete', [AdminController::class, 'deleteTag']);

// COURSE COURSE
Route::get('/courses', [CourseController::class, 'courses']);
Route::get('/courses/{id}', [CourseController::class, 'viewCourse']);

Route::get('/teacher', [TeacherController::class, 'dashboard']);
Route::get('/teacher/pending', [TeacherController::class, 'pending']);

Route::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
