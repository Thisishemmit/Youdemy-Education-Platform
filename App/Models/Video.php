<?php

namespace App\Models;

use Helpers\Database;

class Video extends Content
{

    protected $duration;

    public static function create(Database $db, $course_id, $path, $duration, $title, $description)
    {
        $video = new self($db);
        $content_id = $video->createContent($course_id, $path, 'video', $title, $description);

        if ($content_id) {
            $sql = 'INSERT INTO Videos (content_id, duration) VALUES (:content_id, :duration)';
            $params = [':content_id' => $content_id, ':duration' => $duration];

            if ($db->query($sql, $params)) {
                return self::loadById($db, $content_id);
            }
        }
        return false;
    }

    public static function loadById(Database $db, $id)
    {
        $sql = 'SELECT Contents.*, Videos.duration 
                FROM Contents 
                JOIN Videos ON Videos.content_id = Contents.id 
                WHERE Contents.id = :id';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);

        if ($result) {
            $video = new self($db);
            $video->hydrate($result);
            return $video;
        }
        return false;
    }

    public static function all(Database $db)
    {
        $sql = 'SELECT Contents.*, Videos.duration 
                FROM Contents 
                JOIN Videos ON Videos.content_id = Contents.id';
        $results = $db->fetchAll($sql);

        if ($results) {
            $videos = [];
            foreach ($results as $result) {
                $video = new self($db);
                $video->hydrate($result);
                $videos[] = $video;
            }
            return $videos;
        }
        return false;
    }

    public static function allByCourseId(Database $db, $course_id)
    {
        $sql = 'SELECT Contents.*, Videos.duration 
                FROM Contents 
                JOIN Videos ON Videos.content_id = Contents.id 
                WHERE Contents.course_id = :course_id';
        $params = [':course_id' => $course_id];
        $results = $db->fetchAll($sql, $params);

        if ($results) {
            $videos = [];
            foreach ($results as $result) {
                $video = new self($db);
                $video->hydrate($result);
                $videos[] = $video;
            }
            return $videos;
        }
        return false;
    }

    public function hydrate($data)
    {
        $this->id = $data['id'];
        $this->course_id = $data['course_id'];
        $this->title = $data['title'];
        $this->type = $data['type'];
        $this->description = $data['description'];
        $this->path = $data['path'];
        $this->duration = $data['duration'];
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

    public function getDuration()
    {
        return $this->duration;
    }

    public function updateDuration($duration)
    {
        $sql = 'UPDATE Videos SET duration = :duration WHERE content_id = :content_id';
        $params = [':content_id' => $this->id, ':duration' => $duration];
        if ($this->db->query($sql, $params)) {
            $this->duration = $duration;
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
        return $file['type'] === 'video/mp4';
    }

    public static function validateSize($file)
    {
        $max_size = 100 * 1024 * 1024;
        return $file['size'] <= $max_size;
    }

    public static function upload($file)
    {
        $targetDir = 'uploads/videos/';
        $fileName = md5(basename($file['name']) . time()) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $targetPath = $targetDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $targetPath;
        }
        return false;
    }

    public function delete()
    {
        $sql = 'DELETE FROM Videos WHERE content_id = :content_id';
        $params = [':content_id' => $this->id];
        if ($this->db->query($sql, $params)) {
            return parent::deleteContent();
        }
        return false;
    }
}
