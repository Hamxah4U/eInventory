<?php
    require 'Database.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $unit = $_POST['unit'];
      $product = $_POST['product'];
      $qty = $_POST['qty'];
      $price = $_POST['price'];
      $ExpiryDate = $_POST['ExpiryDate'];
      $purchasePrice = htmlspecialchars($_POST['purchasePrice']);

      $errors = [];
      $success = [];

      if(empty(trim($ExpiryDate))){
        $errors['ExpiryDate'] = 'ExpiryDate is required!';
      }

      if($unit == '--choose--'){
        $errors['dpt'] = 'Department is required!';
      }

      if(empty(trim($product))){
        $errors['product'] = 'Product is required!';
      }

      if(empty(trim($price))){
        $errors['price'] = 'Price is required!';
      }

      if (!empty($price) && floatval($price) < 0) {
        $errors['price_'] = 'Price cannot be less than 0';
      }

      if(empty(trim($qty))){
        $errors['qty'] = 'Quantity is required!';
      }elseif(! empty($qty) && floatval($qty) < 0){
        $errors['qty'] = 'Quantity cannot be less than 0';
      }

      if(empty(trim($purchasePrice))){
        $errors['purchasePrice'] = 'Purchase cost is required!';
      }elseif(! empty($purchasePrice) && floatval($purchasePrice) < 0){
        $errors['purchasePrice'] = 'Purchase cost cannot be less than 0';
      }

      $stmtpro = $db->checkExist('SELECT `SupplyID`,`Quantity`,`Department`, `ProductName`, `ExpiryDate` FROM `supply_tbl` WHERE `ExpiryDate` = :ExpiryDate AND `Department` = :Department AND `ProductName` = :ProductName',[
        ':Department' => $unit,
        ':ProductName' => $product,
        ':ExpiryDate' => $ExpiryDate
      ]);
      $productExist = $stmtpro->fetch(PDO::FETCH_ASSOC);
      
      // if($productExist > 0){
      //   $errors['productExist'] = 'already exist!';
      // }

      if(empty($errors)){
        session_start();
        if($productExist > 0){
          $newQty = $productExist['Quantity'] + $qty;
          $SupplyID = $productExist['SupplyID'];
          $pro = $productExist['ProductName'];

          $stmtupdate = $db->conn->prepare("UPDATE supply_tbl SET Quantity = :newQty, Price = :price WHERE ProductName = :product");
          $result = $stmtupdate->execute([
            ':newQty' => $newQty,
            ':price' => $price,
            ':product' => $pro
          ]);
          
        
          if($result){
            $success['message'] = 'Product stored successfully!';
          }
          //$stmt = $db->checkExist('UPDATE `supply_tbl` SET `Quantity` = '51' WHERE `supply_tbl`.`SupplyID` = 27');
        }else{
          $user = $_SESSION['email'];
          $stmt = $db->conn->prepare("INSERT INTO `supply_tbl` (`Department`,`ProductName`,`Quantity`,`Price`,`Pprice`,`ExpiryDate`,`RecordedBy`) VALUES (:dpt, :product, :qty, :price, :Pprice, :ExpiryDate, :RecordedBy) ");
          $stmt->bindParam(':dpt', $unit, PDO::PARAM_INT);
          $stmt->bindParam('product', $product, PDO::PARAM_STR);
          $stmt->bindParam(':qty', $qty, PDO::PARAM_INT);
          $stmt->bindParam(':price', $price, PDO::PARAM_INT);
          $stmt->bindParam(':Pprice', $purchasePrice, PDO::PARAM_INT);
          $stmt->bindParam(':ExpiryDate', $ExpiryDate);
          $stmt->bindParam(':RecordedBy', $user);
          $result = $stmt->execute();
          if($result){
            $success['message'] = 'Product stored successfully!';
          }
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
          'message' => $success,
        ]);
      }
    }
?>