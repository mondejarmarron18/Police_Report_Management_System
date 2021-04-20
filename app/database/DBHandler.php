<?php
include_once('../config/config.php');

class DBHandler {
    private $servername = DB_HOST;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $dbname = DB_NAME;

    public function connect() {
        //Data Source Name
        $this->dsn = "mysql:host=$this->servername;dbname=$this->dbname;";

        try {
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            );

            return new PDO($this->dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }  
}

?>