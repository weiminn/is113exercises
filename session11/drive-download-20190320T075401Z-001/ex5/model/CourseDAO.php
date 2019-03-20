<?php

class CourseDAO {

    public function retrieveAll() {
        $connMgr = new ConnectionManager();          
        $conn = $connMgr->getConnection();
        
        $sql = 'SELECT * FROM course';
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $result = [];
        while($row = $stmt->fetch()) {
            $result[] = new Course($row['title'], $row['section'], $row['instructor']);
        }

        $stmt = null;
        $conn = null;

        return $result;
    }
    
    public function add($course) {
        $connMgr = new ConnectionManager();       
        $conn = $connMgr->getConnection();
         
        $sql = 'insert into course (title, section, instructor) values (:title, :section, :instructor)';
        $stmt = $conn->prepare($sql); 

        $stmt->bindParam(':title', $course->title, PDO::PARAM_STR);
        $stmt->bindParam(':section', $course->section, PDO::PARAM_STR);
        $stmt->bindParam(':instructor', $course->instructor, PDO::PARAM_STR);
        
        $isAddOK = $stmt->execute();

        $stmt = null;
        $conn = null;

        return $isAddOK;
    }
}


?>