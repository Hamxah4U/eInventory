<?php
require 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tCode'])) {
    $tCode = htmlspecialchars($_POST['tCode']);
    $errors = [];

    try {
        $db->conn->beginTransaction();

        // Step 1: Validate the transaction by updating the Status in transaction_tbl
        $stmt = $db->conn->prepare('UPDATE transaction_tbl SET `Status` = "Paid" WHERE tCode = :tCode');
        $stmt->bindParam(':tCode', $tCode);
        $result = $stmt->execute();

        if ($result) {
            // Step 2: Fetch all products related to the transaction
            $stmtFetch = $db->conn->prepare('SELECT Product, tDepartment, qty FROM transaction_tbl WHERE tCode = :tCode');
            $stmtFetch->bindParam(':tCode', $tCode);
            $stmtFetch->execute();
            $transactions = $stmtFetch->fetchAll(PDO::FETCH_ASSOC);

            if($transactions){
                foreach ($transactions as $i => $transaction) {
                    $product = $transaction['Product'];
                    $department = $transaction['tDepartment'];
                    $issuedQty = $transaction['qty'];

                    // Step 3: Get the current Quantity from supply_tbl for each product
                    $stmtSupply = $db->conn->prepare('SELECT * FROM supply_tbl WHERE Department = :dpt AND SupplyID = :ProductName');
                    $stmtSupply->execute([
                        ':dpt' => $department,
                        ':ProductName' => $product
                    ]);
                    $supply = $stmtSupply->fetch(PDO::FETCH_ASSOC);

                    if($supply){
                        $availableQuantity = $supply['Quantity'];

                        // Step 4: Calculate new quantity
                        $newQuantity = $availableQuantity - $issuedQty;

                        // Step 5: Update the Quantity in the supply_tbl for each product
                        $stmtUpdate = $db->conn->prepare('UPDATE supply_tbl SET Quantity = :newQuantity WHERE SupplyID = :product AND Department = :dpt');
                        $stmtUpdate->execute([
                            ':newQuantity' => $newQuantity,
                            ':product' => $product,
                            ':dpt' => $department
                        ]);
                    } else {
                        throw new Exception('Supply record not found for product: ' . $product);
                    }
                }

                // Step 6: Commit transaction
                $db->conn->commit();

                echo json_encode([
                    'status' => true,
                    'message' => 'Transaction validated and stock updated successfully.'
                ]);
            } else {
                throw new Exception('No transaction records found.');
            }
        } else {
            throw new Exception('Failed to validate the transaction.');
        }
    } catch (Exception $e) {
        // Rollback if there was any error
        $db->conn->rollBack();
        $errors['error'] = $e->getMessage();
        echo json_encode([
            'status' => false,
            'errors' => $errors
        ]);
    }
} else {
    echo json_encode([
        'status' => false,
        'message' => 'Invalid request.'
    ]);
}

?>

<?php
// require 'Database.php';

// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tCode'])) {
//     $tCode = htmlspecialchars($_POST['tCode']);
//     $errors = [];

//     $stmt = $db->conn->prepare('UPDATE transaction_tbl SET `Status` = "Paid" WHERE tCode = :tCode');
//     $stmt->bindParam(':tCode', $tCode);
//     $result = $stmt->execute();

//     if ($result) {
//         echo json_encode([
//             'status' => true,
//             'message' => 'Transaction validated successfully.'
//         ]);
//     } else {
//         $errors['error'] = 'Failed to validate the transaction.';
//         echo json_encode([
//             'status' => false,
//             'errors' => $errors
//         ]);
//     }
// } else {
//     echo json_encode([
//         'status' => false,
//         'message' => 'Invalid request.'
//     ]);
// }
?>