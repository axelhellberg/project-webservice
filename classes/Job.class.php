<?php 
class Job {
    private $db;

    public $id;
    public $workplace;
    public $title;
    public $start_date;
    public $end_date;

    public function __construct($pdo) {
        $this->db = $pdo; // set database connection property
    }

    public function get_jobs($id = false) {
        if ($id) {
            $stmt = $this->db->prepare('SELECT * FROM job WHERE id = :id');
            $stmt->execute([ 'id' => $id ]); // execute
            $row = $stmt->fetch(); // get single row
            return $row; // return single row
        } else {
            $stmt = $this->db->prepare('SELECT * FROM job'); // statement for getting all jobs
            $stmt->execute(); // execute
            $rows = $stmt->fetchAll(); // get all rows
            return $rows; // return all rows
        }
    }

    public function add_job() { // function to add job
        $data = array( // array with data with stripped tags
            'workplace' => strip_tags($this->workplace),
            'title' => strip_tags($this->title),
            'start_date' => strip_tags($this->start_date),
            'end_date' => strip_tags($this->end_date)
        );

        $stmt = $this->db->prepare('INSERT INTO job (workplace, title, start_date, end_date) VALUES (:workplace, :title, :start_date, :end_date)'); // prepared statement for SQL

        return $stmt->execute($data); // execute statement with data array
    }

    public function delete_jobs($id = false) {
        if ($id) {
            $stmt = $this->db->prepare('DELETE FROM job WHERE id = :id');
            return $stmt->execute([ 'id' => $id ]);
        } else {
            $stmt = $this->db->prepare('DELETE FROM job');
            return $stmt->execute();
        }
    }

    public function update_job() {
        $data = array( // array with data with stripped tags
            'workplace' => strip_tags($this->workplace),
            'title' => strip_tags($this->title),
            'start_date' => strip_tags($this->start_date),
            'end_date' => strip_tags($this->end_date),
            'id' => $this->id
        );

        $stmt = $this->db->prepare('UPDATE job SET workplace = :workplace, title = :title, start_date = :start_date, end_date = :end_date WHERE id = :id'); // statment for updating specific job with id

        return $stmt->execute($data); // execute statement with new data
    }
}
?>