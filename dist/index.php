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
    <main id="view-panel" class="absolute top-16 left-80 p-10 -z-10">
      <?php include $page.'.php' ?>
      <div class="modal fade" id="uni_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"></h5>
            </div>
          <div class="modal-body"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirmation</h5>
            </div>
            <div class="modal-body">
              <div id="delete_content"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="viewer_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <button type="button" class="btn-cloxse" data-dismiss="modal"><span class="fa fa-times"></span></button>
            <img src="" alt="">
          </div>
        </div>
      </div>
    </main>


<script src="../src/script.js"></script>
<script>
window.uni_modal = function($title = '' , $url='',$size=""){
  $.ajax({
      url:$url,
      error:err=>{
          console.log()
          alert("An error occured");
      },
      success:function(resp){
          if(resp){
              $('#uni_modal .modal-title').html($title)
              $('#uni_modal .modal-body').html(resp)
              if($size != ''){
                  $('#uni_modal .modal-dialog').addClass($size)
              }else{
                  $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md")
              }
              $('#uni_modal').modal({
                show:true,
                backdrop:'static',
                keyboard:false,
                focus:true
              })
          }
      }
  })
}
window._conf = function($msg='',$func='',$params = []){
  $('#confirm_modal #confirm').attr('onclick',$func+"("+$params.join(',')+")")
  $('#confirm_modal .modal-body').html($msg)
  $('#confirm_modal').modal('show')
}

$(function() {
   $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active');
});
</script>
</body>
</html>