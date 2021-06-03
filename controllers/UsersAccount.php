<?php 
namespace controller;
require_once('../models/UsersAccount.php');
use model;

class UsersAccount extends model\UsersAccount
{
    public function getUserRecords() 
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

    public function getUserRecordByUsername(){
        $username = $_POST['username'];
        
        return $this->getUserByUsername($username);
    }

    public function getUsersCount() {
        $sql = "SELECT COUNT(id) FROM user_account";
        $stmt = $this->connect()->query($sql);

        return $stmt->fetch()?:0;
    }

    public function verifyUserRecord() 
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = $this->verifyUser($username, $password);

        return $result;
    }

    public function addUserRecord() 
    {  
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $complete_name = $_POST['complete_name']; 
        $username = $_POST['username']; 
        //Auto Generated Password
        //$password = 'P'. mt_rand(100, 999) .'R'. date('m') .'M'. date('d') .'S'; 
        $password = $_POST['password'];
        $email = $_POST['email']; 
        $contact_number = $_POST['contact_number']; 
        $crimes_access = $_POST['crimes_access']; 
        $lost_items_access = $_POST['lost_items_access'];
        $surrendered_items_access = $_POST['surrendered_items_access'];
        $missing_persons_access = $_POST['missing_persons_access'];
        $users_account_access = $_POST['users_account_access'];
        $date_registered = $date; 
        
        $result = $this->addUser($complete_name, $username, $password, $email, $contact_number, $crimes_access, $lost_items_access, $surrendered_items_access, $missing_persons_access, $users_account_access, $date_registered);

        return $result;
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

use controller;
$UsersAccount = new controller\UsersAccount();
header('Content-type: application/json');

$fn = $_GET['fn'];
echo json_encode($UsersAccount->$fn());
?>