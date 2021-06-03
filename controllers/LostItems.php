<?php
namespace controller;
require_once '../models/LostItems.php';
use model;

class LostItems extends model\LostItems 
{
    public function addLostItemRecord()
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Ymd_hisA');

        
        if (!empty($_FILES['image'])) {
            $image = $_FILES['image'];
            $exploded_image_name = explode('.', $_FILES['image']['name']);
            $image_extention = $exploded_image_name[count($exploded_image_name) - 1];
            $image_name = 'PRMS_' . $date .'.'. $image_extention;
        }  
        else {
            $image_name = null;
        }

        $person_to_contact_id = $_POST['person_to_contact_id']==''?0:$_POST['person_to_contact_id'];  
        $type = $_POST['type'];  
        $description = $_POST['description'];  
        $location_lost = $_POST['location_lost'];  
        $date_lost = $_POST['date_lost']==''? null:$_POST['date_lost']; 
        $time_lost = $_POST['time_lost']==''? null:$_POST['time_lost']; 
        
        if ($image_name != null)
            move_uploaded_file($image['tmp_name'], '../wwwroot/img/lost_items/'.$image_name);

        $result = $this->addLostItem($person_to_contact_id, $image_name, $type, $description, $location_lost, $date_lost, $time_lost);

        return $result;
    }

    public function updateLostItemRecord()
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Ymd_hisA');

        
        if (!empty($_FILES['image'])) {
            $image = $_FILES['image'];
            $exploded_image_name = explode('.', $_FILES['image']['name']);
            $image_extention = $exploded_image_name[count($exploded_image_name) - 1];
            $image_name = 'PRMS_' . $date .'.'. $image_extention;
        }  
        else {
            $image_name = null;
        }

        $lost_item_id = $_POST['lost_item_id'];
        $person_to_contact_id = $_POST['person_to_contact_id']==''?0:$_POST['person_to_contact_id'];  
        $type = $_POST['type'];  
        $description = $_POST['description'];  
        $location_lost = $_POST['location_lost'];  
        $date_lost = $_POST['date_lost']==''? null:$_POST['date_lost']; 
        $time_lost = $_POST['time_lost']==''? null:$_POST['time_lost']; 
        
        if ($image_name != null)
            move_uploaded_file($image['tmp_name'], '../wwwroot/img/lost_items/'.$image_name);

        return $this->updateLostItem($lost_item_id, $person_to_contact_id, $image_name, $type, $description, $location_lost, $date_lost, $time_lost);
    }

    public function deleteLostItemRecord()
    {
        $lost_item_id = $_POST['lost_item_id']; 

        return $this->deleteLostItem($lost_item_id);
    }

    public function getLostItemRecords()
    {
        return $this->getLostItems();
    }

    public function getLostItemRecord()
    {
        $param = $_POST['search_text'];

        return $this->getLostItem($param);
    }

    public function getLostItemRecordById()
    {
        $item_id = $_POST['item_id'];

        return $this->getLostItemById($item_id);
    }

    public function getLostItemRecordCount()
    {
        return $this->getLostItemCount();
    }

    public function claimItemRecord()
    {
        $lost_item_id = $_POST['lost_item_id'];

        return $this->claimItem($lost_item_id);
    }

    public function getLostItemRecordByDatesOfMonth()
    {
        return $this->getLostItemsByDatesOfMonth();
    }

    public function getLostItemsCountRecordByDates()
    {
        return $this->getLostItemsCountByDates();
    }

    public function getLostItemRecordsByDate(){
        $date_lost = $_POST['date_lost'];

        return $this->getLostItemsByDate($date_lost);
    }

}

use controller;
$LostItems = new controller\LostItems();
header('Content-type: application/json');

$fn = $_GET['fn'];
echo json_encode($LostItems->$fn());

?>