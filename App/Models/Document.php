<?php
namespace App\Models;
use Helpers\Database;
use App\Models\Content;


class Document extends Content{
    private $fileSize;
    private $fileExt;

    public function __construct(Database $db){
        parent::__construct($db);
    }

    public static function create(Database $db, $courseId, $title, $description, $path, $fileSize, $fileExt){
        $path = 'documents/' . $path;
        $id = self::createContent($db, $courseId, $title, $description, 'document', $path);
        if ($id) {
            $sql = "INSERT INTO Documents (content_id, file_size, file_ext) VALUES (:content_id, :file_size, :file_ext)";
            $params = [':content_id' => $id, ':file_size' => $fileSize, ':file_ext' => $fileExt];
            if ($db->query($sql, $params)) {
                $id = $db->lastInsertId();
                $document = self::load($db, $id);
                return $document;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function hydrate($data){
        parent::hydrate($data);
        $this->fileSize = $data['file_size'];
        $this->fileExt = $data['file_ext'];
    }

    public static function load(Database $db, $id){
        $sql = 'SELECT Contents.*, Documents.file_size, Documents.file_ext FROM Contents JOIN Documents ON Contents.id = Documents.content_id WHERE Contents.id = :id';
        $params = [':id' => $id];
        $result = $db->fetch($sql, $params);
        if ($result !== false) {
            $document = new self($db);
            $document->hydrate($result);
            return $document;
        } else {
            return false;
        }
    }

    public static function loadAll(Database $db, $courseId){
        $sql = 'SELECT Contents.*, Documents.file_size, Documents.file_ext FROM Contents JOIN Documents ON Contents.id = Documents.content_id WHERE Contents.course_id = :course_id';
        $params = [':course_id' => $courseId];
        $result = $db->fetchAll($sql, $params);
        if ($result !== false) {
            $documents = [];
            foreach ($result as $document) {
                $d = new self($db);
                $d->hydrate($document);
                $documents[] = $d;
            }
            return $documents;
        } else {
            return false;
        }
    }

    public function getFileSize(){
        return $this->fileSize;
    }

    public function getFileExt(){
        return $this->fileExt;
    }
}
