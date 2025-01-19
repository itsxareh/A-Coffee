<?php 
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$uid = $_SESSION['uid'];
if(!isset($uid)){
   header('location:login.php');
};
$select_profile = $conn->prepare("SELECT * FROM `users` WHERE uid = ?");
$select_profile->execute([$uid]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
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
  <div class="relative z-0 flex h-full w-full overflow-hidden"> 
    <div id="sidebar" class="relative z-3 first-letter:w-[260px] flex-shrink-0 overflow-x-hidden bg-dark-brown">
    <div class="absolute z-2 opacity-80 inset-0  top-0 left-0 right-0 bottom-0 " style="background-color: rgba(0, 0, 0, 0.1);"></div>   
    <div class="h-full"  style="width:260px">
        <div class="flex h-full min-h-0 flex-col">
          <div class="relative h-full w-full flex-1 items-start border-white/20">
            <div class="absolute right-0 top-0 -mr-12 pt-3.5 opacity-100 ">
              <button id="svpClose" type="button" title="Close" class="flex h-10 w-10 items-center justify-center border rounded-lg focus:bg-white" tabindex="-1">
                <img src="../images/close.svg">
              </button>
            </div>
            <nav class="flex h-full w-full flex-col px-3 pb-3.5" style="padding-bottom: 0.875rem;">
              <div class="absolute left-0 top-0 z-20 w-full overflow-hidden transition-all duration-500 invisible max-h-0"></div>
              <div class="flex-col flex-1 transition-opacity duration-500 -mr-2 pr-2 overflow-y-auto">
                <div class="sticky left-0 right-0 top-0 pt-3.5">
                  <div class="datetime p-2 text-center py-10">
                      <div id="date" class="text-lg text-white rosarivo"></div>
                      <div id="time" class="text-lg text-white rosarivo"></div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 pb-2 text-sm text-white">
                  <div>
                    <span>
                      <div class="relative mt-5 h-auto opacity-100">
                        <ol>
                          <li class="relative h-auto opacity-100">
                            <div class="relative rounded-lg active:opacity-90 hover:opacity-90 nav-dashboard">
                              <a class="flex items-center gap-2 p-2" href="index.php?page=dashboard">
                                <div class="relative grow overflow-hidden whitespace-nowrap">
                                  Dashboard
                                </div>
                              </a>
                            </div>
                          </li>
                          <li class="relative h-auto opacity-100">
                            <div class="relative rounded-lg active:opacity-90 hover:opacity-90 nav-inventory">
                              <a class="flex items-center gap-2 p-2" href="index.php?page=inventory">
                                <div class="relative grow overflow-hidden whitespace-nowrap">
                                  Inventory
                                </div>
                              </a>
                            </div>
                          </li>
                          <li class="relative h-auto opacity-100">
                            <div class="relative rounded-lg active:opacity-90 hover:opacity-90 nav-categories">
                              <a class="flex items-center gap-2 p-2" href="index.php?page=categories">
                                <div class="relative grow overflow-hidden whitespace-nowrap">
                                  Categories
                                </div>
                              </a>
                            </div>
                          </li>
                          <li class="relative h-auto opacity-100">
                            <div class="relative rounded-lg active:opacity-90 hover:opacity-90 nav-products">
                              <a class="flex items-center gap-2 p-2" href="index.php?page=products">
                                <div class="relative grow overflow-hidden whitespace-nowrap">
                                  Products
                                </div>
                              </a>
                            </div>
                          </li>
                          <?php if ($fetch_profile['user_type'] == 0) : ?>
                          <li class="relative h-auto opacity-100">
                            <div class="relative rounded-lg active:opacity-90 hover:opacity-90 nav-order">
                              <a class="flex items-center gap-2 p-2" href="index.php?page=order">
                                <div class="relative grow overflow-hidden whitespace-nowrap">
                                  Order
                                </div>
                              </a>
                            </div>
                          </li>
                          <?php endif; ?>
                          <?php if ($fetch_profile['user_type'] == 1) : ?>
                          <li class="relative h-auto opacity-100">
                            <div class="relative rounded-lg active:opacity-90 hover:opacity-90 nav-sales">
                              <a class="flex items-center gap-2 p-2" href="index.php?page=sales">
                                <div class="relative grow overflow-hidden whitespace-nowrap">
                                  Sales
                                </div>
                              </a>
                            </div>
                          </li>
                          <li class="relative h-auto opacity-100">
                            <div class="relative rounded-lg active:opacity-90 hover:opacity-90 nav-staffs">
                              <a class="flex items-center gap-2 p-2" href="index.php?page=staffs">
                                <div class="relative grow overflow-hidden whitespace-nowrap">
                                  Staffs
                                </div>
                              </a>
                            </div>
                          </li>
                          <?php endif; ?>
                        </ol>
                      </div>
                    </span>
                  </div>
                </div>
              </div>
              <?php if ($fetch_profile['user_type'] == 1) : ?>
              <div class="flex flex-col pt-2">
                <div class="flex w-full justify-end">
                  <a title="Activity Log" href="index.php?page=activity_log"><img class="w-6 h-6" src="../images/time-past-svgrepo-com.svg" alt=""></a>
                </div>
              </div>
              <?php endif; ?>
            </nav>
          </div>
        </div>
      </div>
    
    </div>
    
    <div id="main" class="relative z-1 flex h-full max-w-full flex-1 flex-col overflow-hidden">
      <main class="relative h-full w-full flex-1 overflow-auto translate-width">
        <div id="sidebarBtn" class="fixed left-0 top-1/2" style="z-index: 99; transform: translateX(260px) translateY(-50%)">
          <button id="side-button" title="Close Sidebar" class="cursor-pointer">
            <div class="flex h-[72px] w-8 items-center justify-center">
              <img src="../images/more-menu-vertical-line-svgrepo-com.svg" alt="">
            </div>
          </button>
        </div>
        <div role="presentation" class="flex h-full flex-col">
          <div class="flex-1 overflow-hidden">
            <div class="relative h-full">
              <div class="w-full overflow-y-auto h-full">
                <div class="flex flex-col text-sm pb-9">
                  <div class="header sticky top-0 mb-1.5 flex items-center justify-between z-10 h-14 p-2 font-semibold bg-dark-brown">
                    <div id="svpBtn" class="hidden">
                      <button class="relative rounded-md w-10 h-10 flex items-center justify-center">
                        <img class="w-full h-full" src="../images/hamburger-svgrepo-com.svg" alt="">
                      </button>
                    </div>
                    <div class="flex items-center gap-2">
                      <div class="coffee-name"><span class="text-white text-2xl rosarivo">A Coffee</span></div>
                    </div>
                    <div class="user">
                      <div id="profileBtn">
                          <img class="w-10 h-10" src="../images/profile-circle-svgrepo-com.svg" alt="">
                      </div>
                      <div class="nav-profile absolute right-1 -bottom-32 shadow-lg border rounded-lg p-4 w-60 hidden bg-dark-brown">
                          <a href="index.php?page=profile_update" class="salsa text-sm font-normal block w-full p-2 mt-2 rounded-md text-center text-white bg-light-brown shadow-sm hover:text-white transition-colors duration-300">Account Settings</a>
                          <a href="logout.php" class="salsa text-sm font-normal block w-full p-2 mt-2 rounded-md text-center text-white bg-red-600 shadow-sm hover:text-white hover:bg-red-500 transition-colors duration-300">Logout</a>
                      </div>
                    </div>
                  </div>
                  <div class="text-white w-full">
                    <?php $page = isset($_GET['page']) ? $_GET['page'] :'dashboard'; ?>
                    <main class="w-full p-8">
                      <?php include $page.'.php' ?>
                    </main>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
<script src="../src/script.js"></script>
<script>
window.addEventListener('error', function (e) {
  console.error('Error:', e.message, ' at ', e.filename, ':', e.lineno);
});
const profileBtn = document.querySelector('#profileBtn');
const navProfile = document.querySelector('.nav-profile');

profileBtn.addEventListener('click', () => {
    navProfile.classList.toggle('hidden');
});
window.addEventListener('scroll', () => {
    navProfile.classList.remove('active');
});
const svpClose = document.getElementById('svpClose');
const svpBtn = document.querySelector('#svpBtn');
const sidebarBtn = document.getElementById('sidebarBtn');
const sidebar = document.getElementById('sidebar');
const sideBtn = document.getElementById('side-button');
if (!sidebarBtn) {
    console.error('sidebarBtn element not found.');
} else {
    sidebarBtn.addEventListener('click', function () {
        console.log('sidebarBtn clicked');
        sidebar.classList.toggle('sidebar-closed');
        sidebarBtn.classList.toggle('sidebarBtn-closed');
        if (sideBtn.getAttribute('title') === "Open Sidebar") {
            sideBtn.setAttribute('title', "Close Sidebar");
        } else {
            sideBtn.setAttribute('title', "Open Sidebar");
        }
    });
}
svpBtn.addEventListener('click', function(){
  sidebar.classList.toggle('sidebar-open');
})
svpClose.addEventListener('click', function(){
  sidebar.classList.remove('sidebar-open');
})
$(function() {
   $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : 'dashboard' ?>').addClass('active');
});
function displayPhilippinesTime() {
    const now = new Date().toLocaleString("en-US", { timeZone: "Asia/Manila" });
    const date = new Date(now);

    const formattedDate = new Intl.DateTimeFormat("en-US", {
        year: 'numeric', 
        month: 'long',
        day: 'numeric' 
    }).format(date);

    const formattedTime = new Intl.DateTimeFormat("en-US", {
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: true
    }).format(date);

    document.getElementById("date").innerText = `${formattedDate}`;
    document.getElementById("time").innerText =  `${formattedTime}`;
}

// Update the display every second
setInterval(displayPhilippinesTime, 100);

</script>
</body>
</html>