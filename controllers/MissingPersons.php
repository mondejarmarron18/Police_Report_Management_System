<?php
namespace controller;
require_once('../models/MissingPersons.php');
use model;

class MissingPersons extends model\MissingPersons
{
    // public function addMissingPerson($image, $first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $description, $date_last_seen, $time_last_seen, $address_last_seen, $whom_last_seen, $disability) 
    // {
    //     $sql = "INSERT INTO missing_person (image, first_name, middle_name, last_name, name_extention, birth_date, address, description, date_last_seen, time_last_seen, address_last_seen, whom_last_seen, disability) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    //     $stmt = $this->connect()->prepare($sql);
    //     $stmt->execute([$image, $first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $description, $date_last_seen, $time_last_seen, $address_last_seen, $whom_last_seen, $disability]);

    //     //IT WILL RETURN LAST INSERTED ROW PRIOMARY KEY
    //     return $this->connect()->lastInsertId();
    // }

    // protected function updateMissingPerson($missing_person_id, $person_to_contact_id, $returned_person_id, $image, $first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $description, $date_last_seen, $time_last_seen, $address_last_seen, $whom_last_seen, $disability) 
    // {
    //     $sql = "UPDATE missing_person SET person_to_contact_id = ?, returned_person_id = ?, image = ?, first_name = ?, middle_name = ?, last_name = ?, name_extention = ?, birth_date = ?, address = ?, description = ?, date_last_seen = ?, time_last_seen = ?, address_last_seen = ?, whom_last_seen = ?, disability = ? WHERE id = ?";
    //     $stmt = $this->connect()->prepare($sql);
    //     $stmt->execute([$person_to_contact_id, $returned_person_id, $image, $first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $description, $date_last_seen, $time_last_seen, $address_last_seen, $whom_last_seen, $disability, $missing_person_id]);

    //     return $stmt->rowCount();
    // }

    // protected function deleteMissingPerson($missing_person_id) 
    // {
    //     $sql = "UPDATE missing_person SET `deleted` = ? WHERE `id` = ?";
    //     $stmt = $this->connect()->prepare($sql);
    //     $stmt->execute([1, $missing_person_id]);

    //     return $stmt->rowCount();
    // }

    public function getMissingPersonRecords() 
    {
        return $this->getMissingPersons();
    }

    // protected function getMissingPerson($param)
    // {
    //     $sql = "SELECT * FROM missing_person WHERE id = ? OR first_name = ? OR middle_name = ? OR last_name = ? OR name_extention = ? OR birth_date = ? OR address = ? OR description = ? OR date_last_seen = ? OR time_last_seen = ? OR address_last_seen = ? OR disability = ?";
    //     $stmt = $this->connect()->prepare($sql);
    //     $stmt->execute([$param, $param, $param, $param, $param,$param, $param, $param, $param, $param, $param, $param]);

    //     return $stmt->fetchAll()?:0;
    // }

    public function getMissingPersonRecordCount()
    {
        return $this->getMissingPersonCount();
    }

    public function getMissingPersonRecordsCountByDates()
    {
        return $this->getMissingPersonsCountByDates();
    }

    public function getMissingPersonRecordsByDatesOfMonth()
    {
        return $this->getMissingPersonsByDatesOfMonth();
    }

    public function getMissingPersonRecordsByDate()
    {
        $date_last_seen = $_POST['date_last_seen'];

        return $this->getMissingPersonByDate($date_last_seen);
    }
}

use controller;
$MissingPersons = new controller\MissingPersons();
header('Content-type: application/json');

$fn = $_GET['fn'];
echo json_encode($MissingPersons->$fn());
?>