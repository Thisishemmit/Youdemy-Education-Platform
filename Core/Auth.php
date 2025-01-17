<?php

namespace Core;

use App\Models\User;
use Helpers\Database;

class Auth{
    private static $user;
    public static function login(User $user){
        $_SESSION['user']['id'] = $user->getId();
        $_SESSION['user']['role'] = $user->getRole();
        self::$user = $user;
        if($user->getRole() === 'admin'){
            header('Location: /admin');
        }elseif($user->getRole() === 'teacher'){
            header('Location: /teacher');
        } elseif($user->getRole() === 'student'){
            header('Location: /');
        }
        exit;
    }

    public static function logout() {
        $_SESSION = array();
        session_destroy();
        self::$user = null;
        header('Location: /');
    }

    public static function user() {
        if (self::$user === null && isset($_SESSION['user']['id'])) {
            $db = new Database();
            $db->connect();
            self::$user = User::loadById($db, $_SESSION['user']['id']);
            if (!self::$user) {
                self::logout();
            }
        }
        return self::$user;
    }

    public static function check()
    {
        return isset($_SESSION['user']['id']);
    }

    public static function hasRole($role)
    {
        return self::require() && $_SESSION['user']['role'] === $role;
    }

    public static function require()
    {
        if (!self::check()) {
            header('Location: /login');
            exit;
        }
        return true;
    }


    public static function requireAdmin()
    {
        if (!self::hasRole('admin')) {
            header('Location: /login');
            exit;
        }
    }

    public static function requireTeacher()
    {
        if (!self::hasRole('teacher')) {
            header('Location: /login');
            exit;
        }
    }

    public static function requireStudent()
    {
        if (!self::hasRole('student')) {
            header('Location: /login');
            exit;
        }
    }
}
