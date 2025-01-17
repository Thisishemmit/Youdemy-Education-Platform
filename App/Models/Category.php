<?php
namespace App\Models;
use Helpers\Database;

class Category {
    private $id;
    private $name;
    private $description;
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

    public function getDescription() {
        return $this->description;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function hydrate($data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }


    public function delete() {
        if (!isset($this->id)) return false;

        $sql = 'DELETE FROM Categories WHERE id = :id';
        return $this->db->query($sql, [':id' => $this->id]);
    }

    public static function loadById(Database $db, $id) {
        $sql = 'SELECT * FROM Categories WHERE id = :id';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);
        if ($result !== false) {
            $category = new self($db);
            $category->hydrate($result);
            return $category;
        }
        return false;
    }

    public static function all(Database $db) {
        $sql = 'SELECT * FROM Categories ORDER BY name ASC';
        $result = $db->fetchAll($sql);
        if ($result !== false) {
            $categories = [];
            foreach ($result as $data) {
                $category = new self($db);
                $category->hydrate($data);
                $categories[] = $category;
            }
            return $categories;
        }
        return [];
    }

    public static function exists(Database $db, $name) {
        $sql = 'SELECT COUNT(*) FROM Categories WHERE LOWER(name) = LOWER(:name)';
        $params = [':name' => $name];
        $result = $db->fetch($sql, $params);
        return $result !== false && $result['COUNT(*)'] > 0;
    }

    public static function create(Database $db, $name, $description = '') {
        $sql = 'INSERT INTO Categories (name, description) VALUES (:name, :description)';
        $params = [':name' => $name, ':description' => $description];
        $result = $db->query($sql, $params);
        if ($result !== false) {
            $id = $db->lastInsertId();
            return Category::loadById($db, $id);
        }
        return false;
    }

    public static function update(Database $db, $id, $name, $description = '') {
        $sql = 'UPDATE Categories SET name = :name, description = :description WHERE id = :id';
        $params = [':name' => $name, ':description' => $description, ':id' => $id];
        return $db->query($sql, $params);
    }

    public function updateName($name) {
        $sql = 'UPDATE Categories SET name = :name WHERE id = :id';
        $params = [':name' => $name, ':id' => $this->id];
        return $this->db->query($sql, $params);
    }

    public function updateDescription($description) {
        $sql = 'UPDATE Categories SET description = :description WHERE id = :id';
        $params = [':description' => $description, ':id' => $this->id];
        return $this->db->query($sql, $params);
    }
}
