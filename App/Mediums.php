<?php
error_reporting(0);
session_start();
define('DB', 'connection.php');
define('USER_ID', $_SESSION['user']['id']);
define('USER_ROLE', $_SESSION['user']['role']);


class Mediums{


	//Medium Types
    public function medium($medium_id){

        include DB;

		$query = $db->query("SELECT * FROM `mediums` WHERE `id` = '$medium_id' ");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){				
				$id = $row['id'];
				$type = $row['type'];
				$status = $row['status'];
			}
		}

		$db->close();

        return array(
            'id' => $id,
            'type' => $type,
            'status' => $status,
        ); 

	}
}

?>