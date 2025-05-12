<?php

class MysqlConn {

    public $conn;
    public $DB_USER;
    public $DB_PASS;
    public $DB_PORT;
    public $DB_HOST;
    public $DB_NAME;

    function __construct(){
        $env = file_get_contents("/var/www/html/.env");
        $lines = explode("\n", $env);

        foreach($lines as $line){
            preg_match("/([^#]+)\=(.*)/", $line, $matches);

            if(isset($matches[2])){
                putenv(trim($line));
            }
        } 

        $this->DB_USER = getenv("DB_USER");
        $this->DB_PASS = getenv("DB_PASS");
        $this->DB_PORT = getenv("DB_PORT");
        $this->DB_HOST = getenv("DB_HOST");
        $this->DB_NAME = getenv("DB_NAME");

        try {
            // Connect to db
            $this->conn = new PDO("mysql:host=$this->DB_HOST;dbname=$this->DB_NAME;port=$this->DB_PORT", $this->DB_USER, $this->DB_PASS);

            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

    }

    public function getElementById($table_name, $var_list) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM $table_name WHERE id = :id"
        );
        $stmt->execute($var_list);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);

        $this->closeConn($stmt);
    }

    public function insertElement($table_name, $var_list, $msg) {
        $columns = implode(",", array_keys($var_list));

        // Add a colon to vars from an array_keys (ex: :name)
        $colon_columns = implode(",", array_map( 
            function($e) { return ":" . $e; },
            array_keys($var_list)
        ));

        // Prepare the query
        $stmt = $this->conn->prepare(
            "INSERT INTO $table_name ($columns) VALUES ($colon_columns)"
        );

        // Run the query
        $stmt->execute($var_list);

        // Response
        echo json_encode(['message' => $msg]);

        $this->closeConn($stmt);
    }

    public function deleteElementById($table_name, $var_list, $msg) {
        $stmt = $this->conn->prepare("DELETE FROM $table_name WHERE id = :id");
        $stmt->execute($var_list);
        echo json_encode(['message' => $msg]);

        $this->closeConn($stmt);
    }

    private function closeConn(&$stmt) {
        $this->conn = null;
        $stmt = null;
    }

}