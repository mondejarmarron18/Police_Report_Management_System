<?php
namespace model;
require_once('../database/DBHandler.php');
use database;

class Persons extends database\DBHandler
{
    protected function addPerson($first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $contact_number, $email) 
    {
        $sql = "INSERT INTO person (first_name, middle_name, last_name, name_extention, birth_date, address, contact_number, email) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $contact_number, $email]);

        return $this->connect()->lastInsertId();
    }

    protected function updatePerson($person_id, $first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $contact_number, $email) 
    {
        $sql = "UPDATE person SET `first_name` = ?, `middle_name` = ?, `last_name` = ?, `name_extention` = ?, `birth_date` = ?, `address` = ?, `contact_number` = ?, `email` = ? WHERE `id` = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $contact_number, $email, $person_id]);

        return $stmt->rowCount();
    }

    protected function deletePerson($person_id) 
    {
        $sql = "UPDATE person SET `deleted` = ? WHERE `id` = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([1, $person_id]);

        return $stmt->rowCount();
    }

    protected function getPersons() 
    {
        $sql = "SELECT * FROM person";
        $stmt = $this->connect()->query($sql);

        return $stmt->fetchAll()?:0;
    }

    protected function getPerson($param)
    {
        $param = "%$param%";
        $sql = "SELECT * FROM person WHERE (`id` LIKE ? OR `first_name` LIKE ? OR `middle_name` LIKE ? OR `last_name` LIKE ? OR `name_extention` LIKE ? OR `birth_date` LIKE ? OR `address` = ? OR `contact_number` LIKE ? OR `email` LIKE ?) AND `deleted` = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$param, $param, $param, $param, $param, $param, $param, $param, $param, 0]);

        return $stmt->fetchAll()?:0;
    }

    protected function getPersonByName($param)
    {
        $param = "%$param%";
        $sql = "SELECT * FROM person WHERE (`first_name` LIKE ? OR `middle_name` LIKE ? OR `last_name` LIKE ? OR `name_extention` LIKE ?) AND `deleted` = ? LIMIT 5";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$param, $param, $param, $param, 0]);

        return $stmt->fetchAll()?:0;
    }

    protected function getPersonById($person_id)
    {
        $sql = "SELECT * FROM person WHERE id = ? AND deleted = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$person_id, 0]);

        return $stmt->fetch();
    }

    protected function getPersonCount()
    {
        $sql = "SELECT id FROM person WHERE deleted = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([0]);

        return $stmt->rowCount();
    }
}
?>