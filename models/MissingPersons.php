<?php
namespace model;
require_once('../database/DBHandler.php');
use database;

class MissingPersons extends database\DBHandler
{
    public function addMissingPerson($image, $first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $description, $date_last_seen, $time_last_seen, $address_last_seen, $whom_last_seen, $disability) 
    {
        $sql = "INSERT INTO missing_person (image, first_name, middle_name, last_name, name_extention, birth_date, address, description, date_last_seen, time_last_seen, address_last_seen, whom_last_seen, disability) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$image, $first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $description, $date_last_seen, $time_last_seen, $address_last_seen, $whom_last_seen, $disability]);

        //IT WILL RETURN LAST INSERTED ROW PRIOMARY KEY
        return $this->connect()->lastInsertId();
    }

    protected function updateMissingPerson($missing_person_id, $person_to_contact_id, $returned_person_id, $image, $first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $description, $date_last_seen, $time_last_seen, $address_last_seen, $whom_last_seen, $disability) 
    {
        $sql = "UPDATE missing_person SET person_to_contact_id = ?, returned_person_id = ?, image = ?, first_name = ?, middle_name = ?, last_name = ?, name_extention = ?, birth_date = ?, address = ?, description = ?, date_last_seen = ?, time_last_seen = ?, address_last_seen = ?, whom_last_seen = ?, disability = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$person_to_contact_id, $returned_person_id, $image, $first_name, $middle_name, $last_name, $name_extention, $birth_date, $address, $description, $date_last_seen, $time_last_seen, $address_last_seen, $whom_last_seen, $disability, $missing_person_id]);

        return $stmt->rowCount();
    }

    protected function deleteMissingPerson($missing_person_id) 
    {
        $sql = "UPDATE missing_person SET `deleted` = ? WHERE `id` = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([1, $missing_person_id]);

        return $stmt->rowCount();
    }

    protected function getMissingPersons() 
    {
        $sql = "SELECT * FROM missing_person WHERE deleted = 0";
        $stmt = $this->connect()->query($sql);

        return $stmt->fetchAll()?:0;
    }

    protected function getMissingPerson($param)
    {
        $sql = "SELECT * FROM missing_person WHERE id = ? OR first_name = ? OR middle_name = ? OR last_name = ? OR name_extention = ? OR birth_date = ? OR address = ? OR description = ? OR date_last_seen = ? OR time_last_seen = ? OR address_last_seen = ? OR disability = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$param, $param, $param, $param, $param,$param, $param, $param, $param, $param, $param, $param]);

        return $stmt->fetchAll()?:0;
    }

    protected function getMissingPersonCount()
    {
        $sql = "SELECT id FROM missing_person WHERE deleted = 0";
        $stmt = $this->connect()->query($sql);

        return $stmt->rowCount();
    }

    protected function getMissingPersonsCountByDates()
    {
        date_default_timezone_set('Asia/Manila');
        $current_date = "%". date('Y-m') ."%";

        $sql = "SELECT COUNT(date_last_seen) AS missing_person_count, date_last_seen FROM missing_person WHERE date_last_seen LIKE ? AND deleted = ? GROUP BY date_last_seen";
        $stmt =  $this->connect()->prepare($sql);
        $stmt->execute([$current_date, 0]);

        $missing_persons = $stmt->fetchAll();
        $result = array();

        foreach($missing_persons as $missing_person){
            $result[$missing_person->date_last_seen] = $missing_person->missing_person_count;
        }

        return $result;
    }

    protected function getMissingPersonsByDatesOfMonth()
    {
        date_default_timezone_set('Asia/Manila');
        $current_date = "%". date('Y-m') ."%";

        $sql = "SELECT COUNT(date_last_seen) AS missing_person_count, date_last_seen FROM missing_person WHERE date_last_seen LIKE ? AND deleted = ? GROUP BY date_last_seen";
        $stmt =  $this->connect()->prepare($sql);
        $stmt->execute([$current_date, 0]);

        return $stmt->fetchAll();
    }

    protected function getMissingPersonByDate($date_last_seen)
    {
        $sql = "SELECT * FROM missing_person WHERE date_last_seen = ? AND deleted = ? ORDER BY date_last_seen";
        $stmt =  $this->connect()->prepare($sql);
        $stmt->execute([$date_last_seen, 0]);

        return $stmt->fetchAll();
    }
}
?>