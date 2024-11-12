<?php
require 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $success = [];

    $id = $_POST['supplyID']; 
    $unit = htmlspecialchars($_POST['unit']);
    $product = htmlspecialchars($_POST['product']);
    $qty = htmlspecialchars($_POST['qty']);
    $price = htmlspecialchars($_POST['price']);
    $expiryDate = htmlspecialchars($_POST['ExpiryDate']);
    $SupplyID = htmlspecialchars($_POST['supplyID']);

    if ($unit == '--choose--') {
      $errors['unit'] = 'Department cannot be empty!';
    }

    if (empty(trim($product))) {
        $errors['product'] = 'Product cannot be empty!';
    }

    if (empty(trim($qty))) {
        $errors['qty'] = 'Quantity cannot be empty!';
    }

    if (empty(trim($price))) {
        $errors['price'] = 'Price cannot be empty!';
    }

    if (empty(trim($expiryDate))) {
        $errors['ExpiryDate'] = 'Expiry Date cannot be empty!';
    }

    if(empty($errors)){
      $stmt = $db->conn->prepare("UPDATE `supply_tbl` SET `ProductName` = :product, `ExpiryDate` = :ExpiryDate, `Quantity` = :Quantity, `Price` = :Price, Department = :Department  WHERE `SupplyID` = :id ");
      $stmt->bindParam(':product', $product, PDO::PARAM_STR);
      $stmt->bindParam(':ExpiryDate', $expiryDate);
      $stmt->bindParam(':Quantity', $qty, PDO::PARAM_INT);
      $stmt->bindParam(':Price', $price, PDO::PARAM_INT);
      $stmt->bindParam(':Department', $unit, PDO::PARAM_STR);
      $stmt->bindParam(':id', $SupplyID);
      $result = $stmt->execute();
      if($result){
        $success['message'] = 'Record updated!';
      }
    }

    if(count($errors) > 0){
      echo json_encode([
        'status' => false,
        'errors' => $errors
      ]);
    }else{
      echo json_encode([
        'status' => true,
        'message' => $success
      ]);
    }

}
