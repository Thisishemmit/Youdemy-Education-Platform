<?php
namespace App\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Core\BaseController;
use Core\Auth;
use App\Models\User;

class AuthController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function loginPage()
    {
        if (Auth::check()) {
            header('Location: /');
            exit;
        }
        return $this->render('auth/login');
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->setFlash('login', 'Email or password missing', 'error');
            header('Location: /login');
            exit;
        }

        $user = User::loadByEmail($this->db, $email);
        if (!$user) {
            $this->setFlash('login', 'User not found', 'error');
            header('Location: /login');
            exit;
        }

        if (!$user->verifyPassword($password)) {
            $this->setFlash('login', 'Invalid credentials', 'error');
            header('Location: /login');
            exit;
        }

        Auth::login($user);
    }

    public function registerPage()
    {
        if (Auth::check()) {
            header('Location: /');
            exit;
        }
        return $this->render('auth/register');
    }

    public function register()
    {
        $username = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'student';

        if (empty($username) || empty($email) || empty($password)) {
            $this->setFlash('register', 'All fields are required', 'error');
            header('Location: /register');
            exit;
        }

        $existingUser = User::loadByEmail($this->db, $email);
        if ($existingUser) {
            $this->setFlash('register', 'Email already used', 'error');
            header('Location: /register');
            exit;
        }

        if ($role === 'teacher') {
            $user = Teacher::create($this->db, $username, $email, $password);
        } else {
            $user = Student::create($this->db, $username, $email, $password);
        }

        Auth::login($user);
        exit;
    }

    public function logout()
    {
        Auth::logout();
    }
}
