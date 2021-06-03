<?php
namespace model;
require_once '../database/DBHandler.php';
use database;

class LostItems extends database\DBHandler 
{
    protected function addLostItem($person_to_contact_id, $image, $type, $description, $location_lost, $date_lost, $time_lost)
    {
        $sql = 'INSERT INTO lost_item (person_to_contact_id, image, type, description, location_lost, date_lost, time_lost) VALUES(?, ?, ?, ?, ?, ?, ?)';
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$person_to_contact_id, $image, $type, $description, $location_lost, $date_lost, $time_lost]);

        return $stmt->rowCount();
    }

    protected function updateLostItem($lost_item_id, $person_to_contact_id, $image, $type, $description, $location_lost, $date_lost, $time_lost)
    {
        if ($image != null) {
            $sql = 'UPDATE lost_item SET person_to_contact_id = ?, image = ?, type = ?, description = ?, location_lost = ?, date_lost = ?, time_lost = ? WHERE id = ?';
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$person_to_contact_id, $image, $type, $description, $location_lost, $date_lost, $time_lost, $lost_item_id]);
        }
        else {
            $sql = 'UPDATE lost_item SET person_to_contact_id = ?, type = ?, description = ?, location_lost = ?, date_lost = ?, time_lost = ? WHERE id = ?';
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$person_to_contact_id, $type, $description, $location_lost, $date_lost, $time_lost, $lost_item_id]);
        }
        

        return $stmt->rowCount();
    }

    protected function deleteLostItem($lost_item_id)
    {
        $sql = "UPDATE lost_item SET deleted = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([1, $lost_item_id]);

        return $stmt->rowCount();
    }

    protected function getLostItems()
    {
        $sql = "SELECT * FROM lost_item WHERE deleted = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([0]);
        
        return $stmt->fetchAll();
    }

    protected function getLostItem($param)
    {
        
        if (strtolower($param) == "claimed" || strtolower($param) == "missing")
            return $this->getLostItemByStatus($param);

        $param = "%$param%";
        $sql = "SELECT * FROM lost_item WHERE (type LIKE ? OR location_lost LIKE ? OR date_lost LIKE ? OR time_lost LIKE ?) AND deleted = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$param, $param, $param, $param, 0]);

        return $stmt->fetchAll();
    }

    protected function getLostItemByStatus($param)
    {
        if (strtolower($param) == "claimed") 
            $sql = "SELECT * FROM lost_item WHERE surrenderer_id > ? AND deleted = ?";
        else 
            $sql = "SELECT * FROM lost_item WHERE surrenderer_id = ? AND deleted = ?";
        
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([0, 0]);

        return $stmt->fetchAll();
    }

    protected function getLostItemById($lost_item_id)
    {
        $sql = "SELECT * FROM lost_item WHERE id = ? AND deleted = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$lost_item_id, 0]);

        return $stmt->fetch();
    }

    protected function getLostItemCount()
    {
        date_default_timezone_set('Asia/Manila');
        $date = "%". date('Y-m') ."%";

        $sql = "SELECT id FROM lost_item WHERE date_lost LIKE ? AND deleted = ?";
        $stmt =  $this->connect()->prepare($sql);
        $stmt->execute([$date, 0]);

        return $stmt->rowCount();
    }

    protected function claimItem($lost_item_id)
    {
        $sql = "UPDATE lost_item SET surrenderer_id = ? WHERE id = ?";
        $stmt =  $this->connect()->prepare($sql);
        $stmt->execute([1, $lost_item_id]);

        return $stmt->rowCount();
    }

    protected function getLostItemsByDatesOfMonth()
    {
        date_default_timezone_set('Asia/Manila');
        $current_date = "%". date('Y-m') ."%";

        $sql = "SELECT COUNT(date_lost) AS item_lost_count, date_lost FROM lost_item WHERE date_lost LIKE ? AND deleted = ? GROUP BY date_lost";
        $stmt =  $this->connect()->prepare($sql);
        $stmt->execute([$current_date, 0]);

        return $stmt->fetchAll();
    }

    protected function getLostItemsCountByDates()
    {
        date_default_timezone_set('Asia/Manila');
        $current_date = "%". date('Y-m') ."%";

        $sql = "SELECT COUNT(date_lost) AS item_lost_count, date_lost FROM lost_item WHERE date_lost LIKE ? AND deleted = ? GROUP BY date_lost";
        $stmt =  $this->connect()->prepare($sql);
        $stmt->execute([$current_date, 0]);

        $lost_items = $stmt->fetchAll();
        $result = array();

        foreach($lost_items as $lost_item){
            $result[$lost_item->date_lost] = $lost_item->item_lost_count;
        }

        return $result;
    }

    protected function getLostItemsByDate($date_lost)
    {
        $sql = "SELECT * FROM lost_item WHERE date_lost = ? AND deleted = ? ORDER BY date_lost";
        $stmt =  $this->connect()->prepare($sql);
        $stmt->execute([$date_lost, 0]);

        return $stmt->fetchAll();
    }
}

?>