<?php
$uid = $_SESSION['uid'];
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
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
$select_profile = $conn->prepare("SELECT * FROM `users` WHERE uid = ?");
$select_profile->execute([$uid]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

?>

<header class="fixed inset-x-0 top-0 h-16 shadow-md" style="background-color: var(--dark-brown);">

    <div class="flex justify-between items-center h-16 px-4">

        <a href="index.php" class="text-white text-4xl rosarivo">A Coffee</a>

        <!-- <nav class="navbar">
            <a href="index.php?page=marketplace" class="nav-marketplace"><img src="images/icons/marketplace.png" alt=""></a>
            <a href="index.php?page=contact" class="nav-contact"><img src="images/icons/contact-mail.png" alt=""></a>
            <a href="index.php?page=about" class="nav-about"><img src="images/icons/info.png" alt=""></a>
        </nav> -->

        <div class="user">
            <div id="profileBtn">
                <img class="w-10 h-10" src="../images/profile-circle-svgrepo-com.svg" alt="">
            </div>
            <div class="nav-profile absolute right-1 -bottom-32 shadow-lg border rounded-lg p-4 w-60 hidden" style="background-color: var(--light-brown);">
                <a href="index.php?page=profile_update" class="salsa text-lg block w-full p-2 mt-2 rounded-md text-center text-white bg-orange-600 shadow-sm hover:text-white hover:bg-orange-500 transition-colors duration-300">Update profile</a>
                <a href="logout.php" class="salsa text-lg block w-full p-2 mt-2 rounded-md text-center text-white bg-red-600 shadow-sm hover:text-white hover:bg-red-500 transition-colors duration-300">Logout</a>
            </div>
        </div>
    </div>

</header>
<script>
    const profileBtn = document.querySelector('#profileBtn');
    const navProfile = document.querySelector('.nav-profile');

    profileBtn.addEventListener('click', () => {
        navProfile.classList.toggle('hidden');
    });

window.addEventListener('scroll', () => {
    navProfile.classList.remove('active');
});
      
$(function() {
   $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active');
});
</script>