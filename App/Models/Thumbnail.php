<?php
namespace App\Models;
use Helpers\Database;

class Thumbnail {
    private $db;
    private $id;
    private $courseId;
    private $path;
    private $created_at;
    private $updated_at;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getId() {
        return $this->id;
    }

    public function getCourseId() {
        return $this->courseId;
    }

    public function getPath() {
        return $this->path;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function hydrate($data) {
        $this->id = $data['id'];
        $this->courseId = $data['course_id'];
        $this->path = $data['path'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }

    public function delete() {
        if (!isset($this->id)) return false;

        $sql = 'DELETE FROM Thumbnails WHERE id = :id';
        return $this->db->query($sql, [':id' => $this->id]);
    }

    public static function loadById(Database $db, $id) {
        $sql = 'SELECT * FROM Thumbnails WHERE id = :id';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);
        if ($result !== false) {
            $thumbnail = new self($db);
            $thumbnail->hydrate($result);
            return $thumbnail;
        }
        return false;
    }

    public static function loadByCourseId(Database $db, $courseId) {
        $sql = 'SELECT * FROM Thumbnails WHERE course_id = :course_id';
        $params = [':course_id' => $courseId];
        $result = $db->fetch($sql, $params);
        if ($result !== false) {
            $thumbnail = new self($db);
            $thumbnail->hydrate($result);
            return $thumbnail;
        } else {
            return false;
        }
    }
    public static function create(Database $db, $courseId, $path) {
        $sql = 'INSERT INTO Thumbnails (course_id, path) VALUES (:course_id, :path)';
        $params = [':course_id' => $courseId, ':path' => $path];

        if ($db->query($sql, $params)) {
            return self::loadById($db, $db->lastInsertId());
        }
        return false;
    }

    public static function upload($file) {
        $targetDir = 'uploads/thumbnails/';
        $targetFileName = $targetDir . md5(basename($file['name']) . time()) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file($file['tmp_name'], $targetFileName)) {
            return $targetFileName;
        } else {
            return false;
        }
    }

    public static function validateTypr($file) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }
        return true;
    }

    public static function validateSize($file) {
        if ($file['size'] > 1024 * 1024) {
            return false;
        }
        return true;
    }
}

