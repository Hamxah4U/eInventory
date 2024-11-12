<?php
session_start();

$uri = $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['userID']) && $uri != '/' && $uri != '/login') {
   header('Location: /');
   exit();
}

if($uri == '/'){
    require 'controllers/index.php';
}elseif($uri == '/users'){
    require 'controllers/users.php';
}elseif($uri == '/unit'){
    require 'controllers/unit.php';
}elseif($uri == '/product'){
    require 'controllers/product.php';
}elseif($uri == '/report'){
    require 'controllers/report.php';
}elseif($uri == '/dashboard'){
    require 'controllers/dashboard.php';
}elseif($uri == '/logout'){
    require 'controllers/logout.php';
}elseif($uri == '/billing'){
    require 'controllers/billing.php';
}elseif($uri == '/supply'){
    require 'controllers/supply.php';
}elseif($uri == '/changepassword'){
    require 'controllers/changepassword.php';
}else{
    require 'controllers/404.php';
    //echo "Page not found.";
}
