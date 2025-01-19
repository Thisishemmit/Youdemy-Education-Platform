<?php
namespace App\Models;
use Helpers\Database;

abstract class Content {
    protected $db;
    protected $id;
    protected $courseId;
    protected $title;
    protected $description;
    protected $type;
    protected $path;
    protected $status;
    protected $created_at;
    protected $updated_at;

    public function __construct($db) {
        $this->db = $db;
    }


    protected static function createContent(Database $db, $courseId, $title, $description, $type, $path) {
        $sql = "INSERT INTO Contents (course_id, title, description, type, path) VALUES (:course_id, :title, :description, :type, :path)";
        $params = [
            ':course_id' => $courseId,
            ':title' => $title,
            ':description' => $description,
            ':type' => $type,
            ':path' => $path
        ];
        if ($db->query($sql, $params)) {
            return $db->lastInsertId();
        } else {
            return false;
        }
    }

    abstract static public function load(Database $db, $id);
    abstract static public function loadAll(Database $db, $courseId);
    abstract public function hydrate($data);

    public function getId() {
        return $this->id;
    }

    public function getCourseId() {
        return $this->courseId;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getType() {
        return $this->type;
    }

    public function getPath() {
        return $this->path;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

}

