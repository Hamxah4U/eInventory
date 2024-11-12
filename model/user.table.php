<?php
    require 'Database.php';

    $stmt = $db->checkExist('SELECT * FROM `users_tbl`');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($users);
?>