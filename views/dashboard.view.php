<?php
require 'partials/security.php';

require 'partials/header.php';
require 'model/Database.php';
?>

    <!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <?php require 'partials/sidebar.php' ?>

    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php
                require 'partials/nav.php';
            ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                </div>

                <!-- Content Row -->
                <div class="row">
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Daily)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                          <?php
                                            $stmt = $db->query('SELECT COALESCE(SUM(Amount), 0) AS `dailyTotal` FROM `transaction_tbl` WHERE `TransacDate` = CURRENT_DATE');
                                            $daily = $stmt->fetch(PDO::FETCH_ASSOC);
                                            echo number_format($daily['dailyTotal'], 2, '.');
                                          ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                      <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (MOnthly)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                          <?php
                                              $stmt = $db->query('SELECT COALESCE(SUM(`Amount`), 0) AS `monthlyTotal` FROM `transaction_tbl`WHERE MONTH(`TransacDate`) = MONTH(CURRENT_DATE) AND YEAR(`TransacDate`) = YEAR(CURRENT_DATE)');
                                              $monthly = $stmt->fetch(PDO::FETCH_ASSOC);
                                              echo number_format($monthly['monthlyTotal'], 2, '.');
                                          ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Earnings (Yearly)</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                  <?php
                                                    $stmt = $db->query('SELECT COALESCE(SUM(`Amount`), 0) AS `yearlyTotal` FROM `transaction_tbl` WHERE YEAR(`TransacDate`) = YEAR(CURRENT_DATE)');
                                                    $yearlyTotal = $stmt->fetch(PDO::FETCH_ASSOC);
                                                    echo number_format($yearlyTotal['yearlyTotal'], 2, '.');
                                                  ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                  <?php
                                    $stmt = $db->query('SELECT COALESCE(SUM(`Amount`), 0) AS `totalTransaction` FROM `transaction_tbl`');
                                    $total = $stmt->fetch(PDO::FETCH_ASSOC);
                                    echo number_format($total['totalTransaction'], '2', '.');
                                  ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

                <br/>

                <div class="row">
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Profit (Daily)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                          <?php
                                            $stmt = $db->query('SELECT COALESCE(SUM(Amount), 0) AS `dailyTotal` FROM `transaction_tbl` WHERE `TransacDate` = CURRENT_DATE');
                                            $daily = $stmt->fetch(PDO::FETCH_ASSOC);
                                            echo number_format($daily['dailyTotal'], 2, '.');
                                          ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                      <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Profit (MOnthly)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                          <?php
                                              $stmt = $db->query('SELECT COALESCE(SUM(`Amount`), 0) AS `monthlyTotal` FROM `transaction_tbl`WHERE MONTH(`TransacDate`) = MONTH(CURRENT_DATE) AND YEAR(`TransacDate`) = YEAR(CURRENT_DATE)');
                                              $monthly = $stmt->fetch(PDO::FETCH_ASSOC);
                                              echo number_format($monthly['monthlyTotal'], 2, '.');
                                          ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Profit (Yearly)</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                  <?php
                                                    $stmt = $db->query('SELECT COALESCE(SUM(`Amount`), 0) AS `yearlyTotal` FROM `transaction_tbl` WHERE YEAR(`TransacDate`) = YEAR(CURRENT_DATE)');
                                                    $yearlyTotal = $stmt->fetch(PDO::FETCH_ASSOC);
                                                    echo number_format($yearlyTotal['yearlyTotal'], 2, '.');
                                                  ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Profit</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                  <?php
                                    $stmt = $db->query('SELECT COALESCE(SUM(`Amount`), 0) AS `totalTransaction` FROM `transaction_tbl`');
                                    $total = $stmt->fetch(PDO::FETCH_ASSOC);
                                    echo number_format($total['totalTransaction'], '2', '.');
                                  ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- Content Row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
<?php
    require 'partials/footer.php';
?>


