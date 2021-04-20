<?php 
require_once('../database/DBHandler.php');

class UserAccount 
{
    private $dbHandler;
    private $user_id;

    public function __construct(...$params)
    {
        $this->dbHandler = new DBHandler();
    }

    public function getUsers() 
    {
        $sql = "SELECT `id`, `username`, `first_name`, `middle_name`, `last_name`, `name_extention`, `address`, `email`, `contact_number`, `access_level` FROM user_account";
        $stmt = $this->dbHandler->connect()->query($sql);

        return $stmt->fetchAll();
    }

    public function getUser($user_id) 
    {
        $sql = "SELECT `username`, `first_name`, `middle_name`, `last_name`, `name_extention`, `address`, `email`, `contact_number`, `access_level` FROM user_account WHERE id = ?";
        $stmt = $this->dbHandler->connect()->prepare($sql);
        $stmt->execute([$user_id]);

        //RETURN MATCHED DATA, ELSE FAILED
        return $stmt->fetch()?:0;
    }

    public function searchUser($param) 
    {
        $sql = "SELECT `id`, `username`, `first_name`, `middle_name`, `last_name`, `name_extention`, `address`, `email`, `contact_number`, `access_level` FROM user_account WHERE `id`= ? OR `username` = ? OR `first_name` = ? OR `middle_name` = ? OR `last_name` = ? OR `name_extention` = ? OR `email` = ? OR `contact_number` = ? OR `address` = ?";
        $stmt = $this->dbHandler->connect()->prepare($sql);
        $stmt->execute([$param, $param, $param, $param, $param, $param, $param, $param, $param]);

        //RETURN ALL MATCHED DATA, ELSE FAILED
        return $stmt->fetchAll()?:0;
    }

    public function loginUser($username, $password) 
    {
        $sql = "SELECT `password` FROM user_account WHERE username = ?";
        $stmt = $this->dbHandler->connect()->prepare($sql);
        $stmt->execute([$username]);

        //RETURN 1 MEANS SUCCESS, ELSE FAILED
        return password_verify($password, $stmt->fetch()->password)?1:0;
    }

    public function usernameExist($username) 
    {
        $sql = "SELECT username FROM user_account WHERE username = ?";
        $stmt = $this->dbHandler->connect()->prepare($sql);
        $stmt->execute([$username]);

        //RETURN 1 MEANS SUCCESS, ELSE FAILED
        return $stmt->rowCount()?1:0;
    }

    public function addUser($username, $password, $first_name, $middle_name, $last_name, $name_extention, $email, $contact_number, $address, $access_level) 
    {   
        if ($this->usernameExist($username))
        {
            //RETURN 0 IF USERNAME IS NOT AVAILABLE
            return 0;
        }
        else 
        {
            //HASHED PASSWORD
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO user_account (`username`, `password`, `first_name`, `middle_name`, `last_name`, `name_extention`, `email`, `contact_number`, `address`, `access_level`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->dbHandler->connect()->prepare($sql);
            $stmt->execute([$username, $hashed_password, $first_name, $middle_name, $last_name, $name_extention, $email, $contact_number, $address, $access_level]);

            //RETURN 1 MEANS SUCCESS, ELSE FAILED
            return $stmt->rowCount()?1:0;
        }
    }

    public function updateUser($user_id, $password, $first_name, $middle_name, $last_name, $name_extention, $email, $contact_number, $address, $access_level) 
    {
        //HASHED PASSWORD
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE user_account SET `password` = ?, `first_name` = ?, `middle_name` = ?, `last_name` = ?, `name_extention` = ?, `email` = ?, `contact_number` = ?, `address` = ?, `access_level` = ? WHERE `id` = ?";
        $stmt = $this->dbHandler->connect()->prepare($sql);
        $stmt->execute([$hashed_password, $first_name, $middle_name, $last_name, $name_extention, $email, $contact_number, $address, $access_level, $user_id]);

        //RETURN 1 MEANS SUCCESS, ELSE FAILED
        return $stmt->rowCount()?1:0;
    }

    public function deleteUser($user_id) 
    {
        $sql = "DELETE FROM user_account WHERE `id` = ?";
        $stmt = $this->dbHandler->connect()->prepare($sql);
        $stmt->execute([$user_id]);

        //RETURN 1 MEANS SUCCESS, ELSE FAILED
        return $stmt->rowCount()?1:0;
    }
} 
?>