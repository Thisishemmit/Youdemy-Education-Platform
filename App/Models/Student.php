<?php
namespace App\Models;

use Helpers\Database;
use App\Models\User;

class Student extends User {
    public function __construct(Database $db) {
        parent::__construct($db);
    }

    public static function create(Database $db, $username, $email, $password, $role = 'student', $status = 'active') {
        return User::create($db, $username, $email, $password, $role, $status);
    }
}
