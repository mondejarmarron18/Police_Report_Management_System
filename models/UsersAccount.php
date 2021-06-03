<?php 
namespace model;
require_once('../database/DBHandler.php');
use database\DBHandler;

class UsersAccount extends DBHandler
{
    protected function getUsers() 
    {
        $sql = "SELECT * FROM user_account WHERE deleted = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([0]);

        return $stmt->fetchAll();
    }

    public function getUser($param) 
    {
        $sql = "SELECT * FROM user_account `username` = ? OR `first_name` = ? OR `middle_name` = ? OR `last_name` = ? OR `name_extention` = ? OR `email` = ? OR `contact_number` = ? OR `address` = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$param, $param, $param, $param, $param, $param, $param, $param, $param]);

        //RETURN ALL MATCHED DATA, ELSE FAILED
        return $stmt->fetchAll()?:0;
    }

    protected function getUserByUsername($username){
        $sql = "SELECT username FROM user_account WHERE username = ? AND deleted = 0";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username]);

        return $stmt->fetch();
    }

    public function getUsersCount() {
        $sql = "SELECT COUNT(id) FROM user_account";
        $stmt = $this->connect()->query($sql);

        return $stmt->fetch()?:0;
    }

    protected function verifyUser($username, $password) 
    {
        $sql = "SELECT * FROM user_account WHERE username = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username]);
        $data = $stmt->fetch();

        if ($stmt->rowCount()) {
            if (password_verify($password, $data->password))
                return $data;
        }
        else {
            return 0;
        }
    }

    protected function addUser($complete_name, $username, $password, $email, $contact_number, $crimes_access, $lost_items_access, $surrendered_items_access, $missing_persons_access, $users_account_access, $date_registered) 
    {   
        //HASHED PASSWORD
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // $sql = "INSERT INTO user_account (`complete_name`, `username`, `password`, `email`, `contact_number`, `crimes_access`, `lost_items_access`, `surrendered_items_access`, `missing_persons_access`, `users_account_access`, ``) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        // $stmt = $this->connect()->prepare($sql);
        // $stmt->execute([$complete_name, $username, $hashed_password, $email, $contact_number, $crimes_access, $lost_items_access, $surrendered_items_access, $missing_persons_access, $users_account_access, $date_registered]);

        $sql = "INSERT INTO user_account (complete_name, username, password, email, contact_number, crimes_access, lost_items_access, surrendered_items_access, missing_persons_access, users_account_access, date_registered) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$complete_name, $username, $hashed_password, $email, $contact_number, $crimes_access, $lost_items_access, $surrendered_items_access, $missing_persons_access, $users_account_access, $date_registered]);

        //RETURN 1 MEANS SUCCESS, ELSE FAILED
        return $stmt->rowCount();
    }

    public function updateUser($user_id, $password, $first_name, $middle_name, $last_name, $name_extention, $email, $contact_number, $address, $access_level) 
    {
        //HASHED PASSWORD
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE user_account SET `password` = ?, `first_name` = ?, `middle_name` = ?, `last_name` = ?, `name_extention` = ?, `email` = ?, `contact_number` = ?, `address` = ?, `access_level` = ? WHERE `id` = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$hashed_password, $first_name, $middle_name, $last_name, $name_extention, $email, $contact_number, $address, $access_level, $user_id]);

        //RETURN 1 MEANS SUCCESS, ELSE FAILED
        return $stmt->rowCount();
    }

    public function deleteUser($user_id) 
    {
        $sql = "DELETE FROM user_account WHERE `id` = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);

        //RETURN 1 MEANS SUCCESS, ELSE FAILED
        return $stmt->rowCount();
    }
} 
?>