<?php
namespace database;
require_once('../config/config.php');
use PDO;
use PDOException;

class DBHandler {
    protected $servername = DB_HOST;
    protected $username = DB_USER;
    protected $password = DB_PASS;
    protected $dbname = DB_NAME;

    protected function connect() {
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