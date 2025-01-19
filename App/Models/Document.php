<?php

namespace App\Models;

use Helpers\Database;

class Document extends Content
{
    protected $file_size;
    protected $file_extension;

    public static function create(Database $db, $course_id, $path, $file_size, $file_extension, $title, $description)
    {
        $document = new self($db);
        $content_id = $document->createContent($course_id, $path, 'document', $title, $description);
        
        if ($content_id) {
            $sql = 'INSERT INTO Documents (content_id, file_size, file_extension) 
                    VALUES (:content_id, :file_size, :file_extension)';
            $params = [
                ':content_id' => $content_id,
                ':file_size' => $file_size,
                ':file_extension' => $file_extension
            ];
            
            if ($db->query($sql, $params)) {
                return self::loadById($db, $content_id);
            }
        }
        return false;
    }

    public static function loadById(Database $db, $id)
    {
        $sql = 'SELECT Contents.*, Documents.file_size, Documents.file_extension 
                FROM Contents 
                JOIN Documents ON Documents.content_id = Contents.id 
                WHERE Contents.id = :id';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);

        if ($result) {
            $document = new self($db);
            $document->hydrate($result);
            return $document;
        }
        return false;
    }

    public static function all(Database $db)
    {
        $sql = 'SELECT Contents.*, Documents.file_size, Documents.file_extension 
                FROM Contents 
                JOIN Documents ON Documents.content_id = Contents.id';
        $results = $db->fetchAll($sql);

        if ($results) {
            $documents = [];
            foreach ($results as $result) {
                $document = new self($db);
                $document->hydrate($result);
                $documents[] = $document;
            }
            return $documents;
        }
        return false;
    }

    public static function allByCourseId(Database $db, $course_id)
    {
        $sql = 'SELECT Contents.*, Documents.file_size, Documents.file_extension 
                FROM Contents 
                JOIN Documents ON Documents.content_id = Contents.id 
                WHERE Contents.course_id = :course_id';
        $params = [':course_id' => $course_id];
        $results = $db->fetchAll($sql, $params);

        if ($results) {
            $documents = [];
            foreach ($results as $result) {
                $document = new self($db);
                $document->hydrate($result);
                $documents[] = $document;
            }
            return $documents;
        }
        return false;
    }

    public function hydrate($data)
    {
        $this->id = $data['id'];
        $this->course_id = $data['course_id'];
        $this->path = $data['path'];
        $this->file_size = $data['file_size'];
        $this->file_extension = $data['file_extension'];
        $this->status = $data['status'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }

    public function updateStatus($status)
    {
        $sql = 'UPDATE Contents SET status = :status WHERE id = :id';
        $params = [':id' => $this->id, ':status' => $status];
        if ($this->db->query($sql, $params)) {
            $this->status = $status;
            return true;
        }
        return false;
    }

    public function updateCourseId($course_id)
    {
        $sql = 'UPDATE Contents SET course_id = :course_id WHERE id = :id';
        $params = [':id' => $this->id, ':course_id' => $course_id];
        if ($this->db->query($sql, $params)) {
            $this->course_id = $course_id;
            return true;
        }
        return false;
    }

    public function getFileSize()
    {
        return $this->file_size;
    }

    public function getFileExtension()
    {
        return $this->file_extension;
    }

    public function updateFileSize($file_size)
    {
        $sql = 'UPDATE Documents SET file_size = :file_size WHERE content_id = :id';
        $params = [':id' => $this->id, ':file_size' => $file_size];
        if ($this->db->query($sql, $params)) {
            $this->file_size = $file_size;
            return true;
        }
        return false;
    }

    public function updatePath($path)
    {
        $sql = 'UPDATE Contents SET path = :path WHERE id = :id';
        $params = [':id' => $this->id, ':path' => $path];
        if ($this->db->query($sql, $params)) {
            $this->path = $path;
            return true;
        }
        return false;
    }

    public static function validateType($file)
    {
        $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        return in_array($file['type'], $allowed_types);
    }


    public static function validateSize($file)
    {
        $max_size = 100 * 1024 * 1024; 
        return $file['size'] <= $max_size;
    }

    public static function upload($file)
    {
        $targetDir = 'uploads/documents/';
        $fileName = md5(basename($file['name']) . time()) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $targetPath = $targetDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $targetPath;
        }
        return false;
    }
}
