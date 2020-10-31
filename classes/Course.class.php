<?php 
class Course {
    private $db;

    public $id;
    public $uni;
    public $title;
    public $start_date;
    public $end_date;

    public function __construct($pdo) {
        $this->db = $pdo; // set database connection property
    }

    public function get_courses($id = false) {
        if ($id) {
            $stmt = $this->db->prepare('SELECT * FROM course WHERE id = :id');
            $stmt->execute([ 'id' => $id ]); // execute
            $row = $stmt->fetch(); // get single row
            return $row; // return single row
        } else {
            $stmt = $this->db->prepare('SELECT * FROM course'); // statement for getting all courses
            $stmt->execute(); // execute
            $rows = $stmt->fetchAll(); // get all rows
            return $rows; // return all rows
        }
    }

    public function add_course() { // function to add course
        $data = array( // array with data with stripped tags
            'uni' => strip_tags($this->uni),
            'title' => strip_tags($this->title),
            'start_date' => strip_tags($this->start_date),
            'end_date' => strip_tags($this->end_date)
        );

        $stmt = $this->db->prepare('INSERT INTO course (uni, title, start_date, end_date) VALUES (:uni, :title, :start_date, :end_date)'); // prepared statement for SQL

        return $stmt->execute($data); // execute statement with data array
    }

    public function delete_courses($id = false) {
        if ($id) {
            $stmt = $this->db->prepare('DELETE FROM course WHERE id = :id');
            return $stmt->execute([ 'id' => $id ]);
        } else {
            $stmt = $this->db->prepare('DELETE FROM course');
            return $stmt->execute();
        }
    }

    public function update_course() {
        $data = array( // array with data with stripped tags
            'uni' => strip_tags($this->uni),
            'title' => strip_tags($this->title),
            'start_date' => strip_tags($this->start_date),
            'end_date' => strip_tags($this->end_date),
            'id' => $this->id
        );

        $stmt = $this->db->prepare('UPDATE course SET uni = :uni, title = :title, start_date = :start_date, end_date = :end_date WHERE id = :id'); // statment for updating specific course with id

        return $stmt->execute($data); // execute statement with new data
    }
}
?>