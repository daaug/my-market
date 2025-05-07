<?php

class MysqlConn {

    public function connect(){
        $env = file_get_contents("../.env");
        $lines = explode("\n",$env);

        foreach($lines as $line){
            preg_match("/([^#]+)\=(.*)/", $line, $matches);

            if(isset($matches[2])){
                putenv(trim($line));
            }
        } 

        $MYSQL_USER = getenv("MYSQL_USER");
        $MYSQL_PASS = getenv("MYSQL_PASS");
        $MYSQL_PORT = getenv("MYSQL_PORT");
        $MYSQL_HOST = getenv("MYSQL_HOST");
        $MYSQL_NAME = getenv("MYSQL_NAME");

        try {
            // Connect to db
            $conn = new mysqli($MYSQL_HOST, $MYSQL_USER, $MYSQL_PASS, $MYSQL_NAME, $MYSQL_PORT);
        } catch(Exception $e) {
            echo $e;
            $conn->close();
            exit();
        }

        //return $conn;
    }

    public function insert($query) {
        
    }

}

