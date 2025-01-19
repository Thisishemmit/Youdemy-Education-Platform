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
}

