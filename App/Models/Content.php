<?php

namespace App\Models;

use Helpers\Database;

abstract class Content
{
    protected $db;
    protected $id;
    protected $type;
    protected $path;
    protected $course_id;
    protected $title;
    protected $description;
    protected $created_at;
    protected $updated_at;
    protected $status;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    abstract public static function loadById(Database $db, $id);
    abstract public static function all(Database $db);
    abstract public static function allByCourseId(Database $db, $course_id);
    abstract public function hydrate($data);
    abstract public function updateStatus($status);
    abstract public function updateCourseId($course_id);
    abstract public function updatePath($path);
    abstract public static function validateType($file);
    abstract public static function validateSize($file);
    abstract public function delete();

    public function deleteContent()
    {
        $sql = 'DELETE FROM Contents WHERE id = :id';
        $params = [':id' => $this->id];
        return $this->db->query($sql, $params);
    }
    protected function createContent($course_id, $path, $type, $title, $description)
    {
        $sql = 'INSERT INTO Contents (course_id, path, type, title, description) VALUES (:course_id, :path, :type, :title, :description)';
        $params = [
            ':course_id' => $course_id,
            ':path' => $path,
            ':type' => $type,
            ':title' => $title,
            ':description' => $description
        ];

        if ($this->db->query($sql, $params)) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCourseId()
    {
        return $this->course_id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function updateTitle($title)
    {
        $sql = 'UPDATE Contents SET title = :title WHERE id = :id';
        $params = [':id' => $this->id, ':title' => $title];
        if ($this->db->query($sql, $params)) {
            $this->title = $title;
            return true;
        }
        return false;
    }

    public function updateDescription($description)
    {
        $sql = 'UPDATE Contents SET description = :description WHERE id = :id';
        $params = [':id' => $this->id, ':description' => $description];
        if ($this->db->query($sql, $params)) {
            $this->description = $description;
            return true;
        }
        return false;
    }
}
