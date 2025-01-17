<?php

namespace Core;

use Helpers\Database;

class BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }

    protected function render(string $view, array $data = []): void
    {
        $viewPath = "../App/Views/{$view}.php";
        if (file_exists($viewPath)) {
            extract($data);
            require $viewPath;
        } else {
            die("View {$view} not found");
        }
    }

    public function setFlash($flashName, $message, $type = 'success'): void
    {
        $_SESSION[$flashName] = [
            'message' => $message,
            'type' => $type
        ];
    }

    public function getFlash($flashName): ?array
    {
        if (isset($_SESSION[$flashName])) {
            $flash = $_SESSION[$flashName];
            unset($_SESSION[$flashName]);
            return $flash;
        }
        return null;
    }

    public function hasFlash($flashName): bool
    {
        return isset($_SESSION[$flashName]);
    }
}
