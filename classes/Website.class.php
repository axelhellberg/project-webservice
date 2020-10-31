<?php 
class Website {
    private $db;

    public $id;
    public $title;
    public $url;
    public $info;

    public function __construct($pdo) {
        $this->db = $pdo; // set database connection property
    }

    public function get_sites($id = false) {
        if ($id) {
            $stmt = $this->db->prepare('SELECT * FROM website WHERE id = :id');
            $stmt->execute([ 'id' => $id ]); // execute
            $row = $stmt->fetch(); // get single row
            return $row; // return single row
        } else {
            $stmt = $this->db->prepare('SELECT * FROM website'); // statement for getting all websites
            $stmt->execute(); // execute
            $rows = $stmt->fetchAll(); // get all rows
            return $rows; // return all rows
        }
    }

    public function add_site() { // function to add website
        $data = array( // array with data with stripped tags
            'title' => strip_tags($this->title),
            'url' => strip_tags($this->url),
            'info' => strip_tags($this->info)
        );

        $stmt = $this->db->prepare('INSERT INTO website (title, url, info) VALUES (:title, :url, :info)'); // prepared statement for SQL

        return $stmt->execute($data); // execute statement with data array
    }

    public function delete_sites($id = false) {
        if ($id) {
            $stmt = $this->db->prepare('DELETE FROM website WHERE id = :id');
            return $stmt->execute([ 'id' => $id ]);
        } else {
            $stmt = $this->db->prepare('DELETE FROM website');
            return $stmt->execute();
        }
    }

    public function update_site() {
        $data = array( // array with data with stripped tags
            'title' => strip_tags($this->title),
            'url' => strip_tags($this->url),
            'info' => strip_tags($this->info),
            'id' => $this->id
        );

        $stmt = $this->db->prepare('UPDATE website SET title = :title, url = :url, info = :info WHERE id = :id'); // statment for updating specific website with id

        return $stmt->execute($data); // execute statement with new data
    }
}
?>