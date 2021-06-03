<?php
namespace model;
require_once '../database/DBHandler.php';
use database;

class Crimes extends database\DBHandler 
{
    protected function addCrime($crime_type, $barangay, $date_occurred, $time_occurred)
    {
        $sql = "INSERT INTO crime (crime_type, barangay, date_occurred, time_occurred) VALUES(?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$crime_type, $barangay, $date_occurred, $time_occurred]);

        return $stmt->rowCount();
    }

    protected function updateCrime($crime_id, $crime_type, $barangay, $date_occurred, $time_occurred)
    {
        $sql = "UPDATE crime SET crime_type = ?, barangay = ?, date_occurred = ?, time_occurred = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$crime_type, $barangay, $date_occurred, $time_occurred, $crime_id]);

        return $stmt->rowCount();
    }

    protected function deleteCrime($crime_id)
    {
        $sql = "UPDATE crime SET deleted = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([1, $crime_id]);

        return $stmt->rowCount();
    }

    protected function getCrimes()
    {
        $sql = "SELECT * FROM crime WHERE deleted = 0";
        $stmt = $this->connect()->query($sql);
        
        return $stmt->fetchAll();
    }

    protected function getCrime($param)
    {           
        $param = "%$param%";

        $sql = "SELECT id, crime_type, barangay, date_occurred, time_occurred FROM crime WHERE (crime_type LIKE ? OR barangay LIKE ? OR date_occurred LIKE ? OR time_occurred LIKE ? ) AND c.deleted = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$param, $param, $param, $param, 0]);

        return $stmt->fetchAll();
    }

    protected function getCrimesCount()
    {
        date_default_timezone_set('Asia/Manila');
        $current_date = "%". date('Y-m') ."%";

        $sql = "SELECT id FROM crime WHERE date_occurred LIKE ? AND deleted = ?";
        $stmt =  $this->connect()->prepare($sql);
        $stmt->execute([$current_date, 0]);

        return $stmt->rowCount();
    }

    protected function getCrimesCountByDates()
    {
        date_default_timezone_set('Asia/Manila');
        $current_date = "%". date('Y-m') ."%";

        $sql = "SELECT COUNT(date_occurred) AS crime_count, date_occurred FROM crime WHERE date_occurred LIKE ? AND deleted = ? GROUP BY date_occurred";
        $stmt =  $this->connect()->prepare($sql);
        $stmt->execute([$current_date, 0]);

        $crimes = $stmt->fetchAll();
        $result = array();

        foreach($crimes as $crime){
            $result[$crime->date_occurred] = $crime->crime_count;
        }

        return $result;
    }

    protected function getCrimesByDatesOfMonth()
    {
        date_default_timezone_set('Asia/Manila');
        $current_date = "%". date('Y-m') ."%";

        $sql = "SELECT COUNT(date_occurred) AS crime_count, date_occurred FROM crime WHERE date_occurred LIKE ? AND deleted = ? GROUP BY date_occurred";
        $stmt =  $this->connect()->prepare($sql);
        $stmt->execute([$current_date, 0]);

        return $stmt->fetchAll();
    }

    protected function getCrimesByDate($date_occurred)
    {
        $sql = "SELECT * FROM crime WHERE date_occurred = ? AND deleted = ? ORDER BY date_occurred";
        $stmt =  $this->connect()->prepare($sql);
        $stmt->execute([$date_occurred, 0]);

        return $stmt->fetchAll();
    }
}

?>