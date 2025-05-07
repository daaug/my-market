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

    public function getElement($query) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

    public function addElement($query, $execute, $msg) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($execute);
        echo json_encode(['message' => $msg]);
    }

}