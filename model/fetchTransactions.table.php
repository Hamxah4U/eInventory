<style>
  /* Centering the content and setting width suitable for thermal printer */
  #contentToPrint {
    width: 70mm;
    margin: 0 auto;
    font-family: Arial, sans-serif;
    font-size: 10px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  th, td {
    padding: 2px 5px;
    text-align: left;
  }

  th {
    font-weight: bold;
  }

  .footer {
    text-align: center;
    margin-top: 10px;
  }

  img {
    display: block;
    margin: 0 auto;
  }

  .center-text {
    text-align: center;
  }
</style>
<?php
require 'Database.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tcode'])) {
    $tCode = htmlspecialchars($_POST['tcode']);
    

    $sql = 'SELECT Customer AS pCustomer, ProductName, TID, tCode, transaction_tbl.Price AS Price, qty, Amount, transaction_tbl.Status AS TStatus  
            FROM transaction_tbl 
            JOIN supply_tbl ON Product = supply_tbl.SupplyID 
            WHERE tCode = :tCode';

    $stmt = $db->checkExist($sql, [':tCode' => $tCode]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($products)): ?>
      <table class="table table-striped mt-0 mb-0">
        <tr class="pt-0 pb-0">
          <th>#</th>
          <th>Service</th>
          <th>Price (&#x20A6)</th>
          <th>Qty</th>
          <th>Amount (&#x20A6)</th>
          <th></th>
        </tr>
        <?php $totalAmount = 0; ?>
        <?php foreach ($products as $i => $row): ?>
          <tr class="pt-0 pb-0">
            <td><?= $i + 1; ?></td>
            <td><?= $row['ProductName']; ?></td>
            <td><?= $row['Price']; ?></td>
            <td><?= $row['qty']; ?></td>
            <td><?= $row['Amount']; ?></td>
            <td>
                <?php if ($row['TStatus'] == 'Not-Paid'): ?>
                  <button type="button" onclick="deleteProduct(<?= $row['TID']; ?>)" class="btn btn-warning">Delete</button>
                <?php else: ?>
                    <?= $row['TStatus']; ?>
                <?php endif; ?>
            </td>
          </tr>
          <?php $totalAmount += $row['Amount']; ?>
        <?php endforeach; ?>
        <tr>
          <?php if($row['TStatus'] == 'Not-Paid'):?>
            <td><input type="submit" onclick="validateTransaction('<?= $row['tCode']; ?>')" class="btn btn-danger" name="validate" value="Validate" /></td>
          <?php elseif($row['TStatus'] == 'Paid'): ?>
          <td><input id="btn2" class="btn btn-dark" type="button" value="Print" onclick="PrintDoc2()" /></td>
          <?php endif; ?>
            <td colspan="3"><strong>Total Amount:</strong></td>
            <td><strong>&#x20A6; <?= number_format($totalAmount, 2, '.', ','); ?></strong></td>
        </tr>
      </table>

      <div id="not_paid" style="display: none;">
        <div id="contentToPrint">
          <?php
            $sql = 'SELECT qty, Amount, ProductName, Product, Customer, ProductName, TID, tCode, transaction_tbl.Price AS Price, qty, Amount, transaction_tbl.Status AS TStatus  
            FROM transaction_tbl 
            JOIN supply_tbl ON Product = supply_tbl.SupplyID 
            WHERE tCode = :tCode AND transaction_tbl.Status = "Paid" ';

            $stmt = $db->checkExist($sql, [':tCode' => $tCode]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($products)): ?>
              <table>
                <tr>
                  <td>
									  <center><img src="images/sunnahHospital.png" style="height: 80px;" alt="Logo"/><br/>
                    <p style="text-align: center;"><strong>Sunna Hospital Plateau State</strong></p>
                    <p style="text-align: center;">Anguwan Rimi Plateau State</p>
                    <p style="text-align: center;">BILLING RECEIPT</p>
                    <p style="text-align: center;">Customer's Copy</p>
                    </center>
                  </td>
                </tr>
              
                <tr>
                  <td colspan="2">TID:</td>
                  <td colspan="3"><?= $tCode; ?></td>
                </tr>

                <tr>
                  <td colspan="2">Customer:</td>
                  <td colspan="3"><?= $row['pCustomer'] ?></td>
                </tr>

                <tr>
                  <th>#</th>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Amount</th>
                </tr>

                <?php
                  $i = 1;
                  $totalAmountC = 0;
                  foreach($products as $p => $row) :?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td><?= $row['ProductName'] ?></td>
                  <td><?= $row['Price'] ?></td>
                  <td><?= $row['qty'] ?></td>
                  <td><?= $row['Amount'] ?></td>
                </tr>
              <?php endforeach ?>
              <tr>
                <td colspan="2"></td>
                <td><strong>Total:</strong></td>
                <td><strong><?= number_format($totalAmount, 2) ?></strong></td>
              </tr>
              </table>
              <div class="footer">
                <p>Printed By: <?= $_SESSION['fname']?></p>
                <p>Date: <?= date('D-M-Y h:i:s') ?></p>
                <p>Powered by: HID Tech +2348037856962</p>
              </div>
            <?php endif ?>
        </div>
      </div>

    <?php endif;
}
?>



<script>
  function PrintDoc2() {
      var printContents = $("#contentToPrint").html();
      var originalContents = $('body').html();
      
      $('body').html(printContents);
      window.print();
      $('body').html(originalContents);
  }
  $(document).ready(function() {
      $('#btn2').click(function() {
          PrintDoc2();
      });
  });
</script>

<script>
  function refreshTransactionTable() {
    const tCode = $('input[name="tcode"]').val();
    $.ajax({
        url: 'model/fetchTransactions.table.php',
        method: 'POST',
        data: { tcode: tCode },
        success: function(data) {
            $('.transaction_table').html(data);
        }
    });
  }


  function deleteProduct(transactionID) {
    if (confirm('Are you sure you want to delete this transaction?')) {
        $.ajax({
            url: 'model/delete.transaction.php',
            method: 'POST',
            data: { tid: transactionID },
            success: function(response) {
              response = JSON.parse(response);
                if(response.status) {
                  console.log(transactionID);
                  refreshTransactionTable();
                  //alert('Transaction deleted successfully.');
                }else {
                  alert('Error: ' + (response.errors ? response.errors.error : 'Unknown error'));
                  console.log(transactionID);
                }
            },
            error: function() {
                alert('Something went wrong. Please try again.');
            }
        });
    }
  }


  function validateTransaction(tCode) {
    //if (confirm('Are you sure you want to validate this transaction?')) {
        $.ajax({
            url: 'model/validateTransaction.php',
            method: 'POST',
            data: { tCode: tCode },
            success: function(response) {
                response = JSON.parse(response);
                if(response.status) {
                  refreshTransactionTable(); 
                }else {
                  alert('Errorddd: ' + (response.message));
                }
            },
            error: function() {
                alert('Something went wrong. Please try again.');
            }
        });
    //}
  }
</script>
