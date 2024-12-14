<style>
        table {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
        }
        hr {
            border: 1px solid black;
        }
        .center {
            text-align: center;
            background-color: white;
        }
        .footer {
            font-size: 8pt;
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

<div id="printinvoice">
<table>
  <tr>
    <td colspan="2" style="text-align:center; background-color:white">
    <img src="../img/sunnahHospital.png" style="height:70px; margin:0" /><br />
        <strong style="margin: 0;"><?= $storeName ?></strong><br />
        <span style="font-size:8pt; margin: 0"><?= $state ?><br /></span>
        <strong style="margin-bottom: 0;">BILLING RECEIPT</strong>
        <br /> Customer's Copy<hr />
    </td>
  </tr>
  <tr>
    <td>TID:</td>
    <td id="tid"><?= $tCode; ?></td>
  </tr>
  <tr>
      <td>Customer:</td>
      <td id="patient"><?= $row['pCustomer'] ?></td>
  </tr>
  <tr>
    <td colspan="2">
      <hr />
      <table id="transactionTable" style="width: 100%;">
          <thead>
            <tr>
              <th>#</th>
              <th>Product</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Amount</th>
            </tr>
          </thead>
            <tbody>
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
                  <td colspan="3"></td>
                  <td><strong>Total:</strong></td>
                  <td><strong><?= number_format($totalAmount, 2) ?></strong></td>
              </tr>
             
            </tbody>
        </table>
        <div class="footer">
            <hr />
            <p style="margin: 0;">Printed By: <?= $_SESSION['fname']?>&nbsp; |&nbsp; Date: <?= date('D-M-Y h:i:s') ?></p>
            <p style="margin: 0;">Powered by: HID Tech +2348037856962</p>
        </div>
    </td>
  </tr>
    </table>
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
