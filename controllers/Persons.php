<?php
namespace controller;
require_once('../models/Persons.php');
use model;

class Persons extends model\Persons
{
    public function addPersonRecord() 
    {
        $first_name = $_POST['first_name']; 
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $name_extention = $_POST['name_extention'];
        $birth_date = $_POST['birth_date'];
        $address = $_POST['address'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];

        return $this->addPerson($first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $contact_number, $email) ;
    }

    public function updatePerson($person_id, $first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $contact_number, $email) 
    {
        $sql = "UPDATE person SET `first_name` = ?, `middle_name` = ?, `last_name` = ?, `name_extention` = ?, `birth_date` = ?, `address` = ?, `contact_number` = ?, `email` = ? WHERE `id` = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $contact_number, $email, $person_id]);

        return $stmt->rowCount();
    }

    public function deletePersonRecord($person_id) 
    {
        $sql = "UPDATE person SET `deleted` = ? WHERE `id` = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([1, $person_id]);

        return $stmt->rowCount();
    }

    public function getPersonRecords() 
    {
        return $this->getPersons();
    }

    public function getPersonRecord($param)
    {
        $sql = "SELECT * FROM person WHERE (`id` = ? OR `first_name` = ? OR `middle_name` = ? OR `last_name` = ? OR `name_extention` = ? OR `birth_date` = ? OR `address` = ? OR `contact_number` = ? OR `email` = ?) AND `deleted` = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$param, $param, $param, $param, $param, $param, $param, $param, $param, 0]);

        return $stmt->fetchAll()?:0;
    }

    public function getPersonRecordByName()
    {
        $param = $_POST['person_name'];

        return $this->getPersonByName($param);
    }

    public function getPersonRecordById()
    {
        $person_id = $_POST['person_id'];

        return $this->getPersonById($person_id);
    }


    public function getPersonCount()
    {
        $sql = "SELECT id FROM person WHERE deleted = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([0]);

        return $stmt->rowCount();
    }
}

use controller;
$Persons = new controller\Persons();
header('Content-type: application/json');

$fn = $_GET['fn'];
echo json_encode($Persons->$fn());
?>