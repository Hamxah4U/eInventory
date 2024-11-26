<?php
    require 'Database.php';
    
    try{
    	$stmt = $db->query('SELECT ProductName, ExpiryDate, Quantity, Price, SupplyDate, RecordedBy, department_tbl.Department AS newdpt FROM supply_tbl INNER JOIN department_tbl ON supply_tbl.Department = department_tbl.deptID WHERE Quantity > 0');
			$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    	echo json_encode($products);
    }catch(PDOException $e){
			die('failed'. $e->getMessage());
		}
?>