<?php
namespace controller;
require_once '../models/Crimes.php';
use model;

class Crimes extends model\Crimes
{
    public function addCrimeRecord()
    {
        $crime_type = $_POST['crime_type'];
        $barangay = $_POST['barangay'];
        $date_occurred = $_POST['date_occurred']==''?null:$_POST['date_occurred'];
        $time_occurred = $_POST['time_occurred']==''?null:$_POST['time_occurred'];

        $result = $this->addCrime($crime_type, $barangay, $date_occurred, $time_occurred);

        return $result;
    }

    public function updateCrimeRecord()
    {       
        $crime_id = $_POST['crime_id'];
        $crime_type = $_POST['crime_type'];
        $barangay = $_POST['barangay'];
        $date_occurred = $_POST['date_occurred'];
        $time_occurred = $_POST['time_occurred'];

        $result = $this->updateCrime($crime_id, $crime_type, $barangay, $date_occurred, $time_occurred);

        return $result;
    }

    public function deleteCrimeRecord()
    {
        $crime_id = $_POST['crime_id'];

        return $this->deleteCrime($crime_id);
    }

    public function getCrimeRecords()
    {
        return $this->getCrimes();
    }

    public function getCrimeRecord()
    {
        $search_text = $_POST['search_text'];

        return $this->getCrime($search_text);
    }

    public function getCrimeRecordsByDatesOfMonth(){
        return $this->getCrimesByDatesOfMonth();
    }

    public function getCrimeRecordsCount()
    {
        return $this->getCrimesCount();
    }

    public function getCrimeRecordsByDate(){
        $date_occurred = $_POST['date_occurred'];
        
        return $this->getCrimesByDate($date_occurred);
    }

    public function getCrimesCountRecordByDates()
    {
        return $this->getCrimesCountByDates();
    }
}

use controller;
$Crimes = new controller\Crimes();
header('Content-type: application/json');

$fn = $_GET['fn'];
echo json_encode($Crimes->$fn());
?>