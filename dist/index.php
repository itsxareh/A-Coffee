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
  <?php
  if(isset($message)){
    foreach($message as $message){
        echo '
        <div class="message rounded-lg p-4 flex items-start">
            <span class="text-sm text-white">'.$message.'</span>
            <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
        </div>
        ';
        echo '
        <script>
          setTimeout(function() {
              var messages = document.getElementsByClassName("message");
              for (var i = 0; i < messages.length; i++) {
                messages[i].remove();
              }
          }, 3000); 
        </script>
        ';
    }
  }
  ?>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <?php $page = isset($_GET['page']) ? $_GET['page'] :'dashboard'; ?>
    <main id="view-panel" class="absolute top-16 left-80 p-10 ">
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