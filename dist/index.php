<?php 
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$uid = $_SESSION['uid'];
if(!isset($uid)){
   header('location:login.php');
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homes</title>

    <link href="../src/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <?php $page = isset($_GET['page']) ? $_GET['page'] :'dashboard'; ?>
    <main id="view-panel" class="absolute top-14 left-80 w-full">
      <?php include $page.'.php' ?>
    </main>

<script src="js/script.js"></script>
</body>
</html>