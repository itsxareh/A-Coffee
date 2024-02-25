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
    <title>Home</title>

    <link href="../src/style.css" rel="stylesheet">
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <?php $page = isset($_GET['page']) ? $_GET['page'] :'dashboard'; ?>
    <main id="view-panel" class="absolute top-16 left-80 p-10 -z-10">
      <?php include $page.'.php' ?>
    </main>

<script src="../src/script.js"></script>
<script>
$(function() {
   $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active');
});
</script>
</body>
</html>