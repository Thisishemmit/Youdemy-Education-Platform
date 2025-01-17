<?php
namespace App\Models;
use Helpers\Database;

class Tag {
    private $id;
    private $name;
    private $created_at;
    private $updated_at;
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function hydrate($data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function save() {
        if (isset($this->id)) {
            $sql = 'UPDATE Tags SET name = :name, updated_at = NOW() WHERE id = :id';
            $params = [
                ':id' => $this->id,
                ':name' => $this->name
            ];
        } else {
            $sql = 'INSERT INTO Tags (name, created_at, updated_at) VALUES (:name, NOW(), NOW())';
            $params = [':name' => $this->name];
        }
        return $this->db->query($sql, $params);
    }

    public function delete() {
        if (!isset($this->id)) return false;
        
        // First remove all course-tag associations
        $sql = 'DELETE FROM CourseTags WHERE tag_id = :id';
        $this->db->query($sql, [':id' => $this->id]);
        
        // Then delete the tag
        $sql = 'DELETE FROM Tags WHERE id = :id';
        return $this->db->query($sql, [':id' => $this->id]);
    }

    public static function loadById(Database $db, $id) {
        $sql = 'SELECT * FROM Tags WHERE id = :id';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);
        if ($result !== false) {
            $tag = new self($db);
            $tag->hydrate($result);
            return $tag;
        }
        return false;
    }

    public static function all(Database $db) {
        $sql = 'SELECT * FROM Tags ORDER BY name ASC';
        $result = $db->fetchAll($sql);
        if ($result !== false) {
            $tags = [];
            foreach ($result as $data) {
                $tag = new self($db);
                $tag->hydrate($data);
                $tags[] = $tag;
            }
            return $tags;
        }
        return [];
    }

    public static function exists(Database $db, $name) {
        $sql = 'SELECT COUNT(*) FROM Tags WHERE LOWER(name) = LOWER(:name)';
        $params = [':name' => $name];
        $result = $db->fetch($sql, $params);
        return $result !== false && $result['COUNT(*)'] > 0;
    }

    public static function create(Database $db, $name) {
        if (self::exists($db, $name)) {
            return false;
        }

        $tag = new self($db);
        $tag->setName($name);
        if ($tag->save()) {
            return $tag;
        }
        return false;
    }
}
