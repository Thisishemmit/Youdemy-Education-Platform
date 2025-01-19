<?php

namespace App\Models;

use Helpers\Database;
use App\Models\Content;

class Video extends Content
{
    private $duration;

    public function __construct(Database $db)
    {
        parent::__construct($db);
    }

    public static function create(Database $db, $courseId, $title, $description, $path,Int $duration)
    {
        $path = 'videos/' . $path;
        $id = self::createContent($db, $courseId, $title, $description, 'video', $path);
        if ($id) {
            $sql = "INSERT INTO Videos (content_id, duration) VALUES (:content_id, :duration)";
            $params = [':content_id' => $id, ':duration' => $duration];
            if ($db->query($sql, $params)) {
                $id = $db->lastInsertId();
                $video = self::load($db, $id);
                return $video;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function hydrate($data)
    {
        parent::hydrate($data);
        $this->duration = $data['duration'];
    }

    public static function load(Database $db, $id)
    {
        $sql = 'SELECT Contents.*, Videos.duration FROM Contents JOIN Videos ON Contents.id = Videos.content_id WHERE Contents.id = :id';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);
        if ($result !== false) {
            $video = new self($db);
            $video->hydrate($result);
            return $video;
        } else {
            return false;
        }
    }

    public static function loadAll(Database $db, $courseId)
    {
        $sql = 'SELECT Contents.*, Videos.duration FROM Contents JOIN Videos ON Contents.id = Videos.content_id WHERE Contents.course_id = :course_id';
        $params = [':course_id' => $courseId];
        $result = $db->fetchAll($sql, $params);
        if ($result !== false) {
            $videos = [];
            foreach ($result as $video) {
                $v = new self($db);
                $v->hydrate($video);
                $videos[] = $v;
            }
            return $videos;
        } else {
            return false;
        }
    }

    public function getDuration()
    {
        return $this->duration;
    }
}
