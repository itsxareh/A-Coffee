<?php
include 'config.php';
ob_start();

if (isset($_POST['login'])) {
    $uid = trim($_POST['uid']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM `users` WHERE uid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$uid]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row['password'])) {
        if ($row['user_type'] == 0 || $row['user_type'] == 1) {
            $_SESSION['uid'] = $row['uid'];
            header('location:index.php');
            exit(); 
        } else {
            $message[] = "Your account has been blocked.";
        }
    } else {
        $message[] = "Invalid UID or password.";
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../src/style.css" rel="stylesheet">

</head>
<body class="h-screen flex flex-col justify-center items-center" style="background-color: #361500;">
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
    <h2 class="text-8xl select-none text-white" style="font-family: 'Rosarivo', cursive;">A Coffee</h2>
    <div class="p-8 rounded-lg shadow-md w-96" style="background-color: #1C0A00">
        <form class="space-y-4" method="post">
            <div>
                <label for="uid" class="text-white block text-lg font-medium" style="font-family: 'Rosarivo', cursive;">UID</label>
                <input type="text" name="uid" id="uid" style="font-family: 'Rosarivo', cursive;" class="mt-1 block w-full rounded-md border-gray-300 shadow focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 p-2">
            </div>
            <div>
                <label for="password" class="text-white block text-lg font-medium" style="font-family: 'Rosarivo', cursive;">Password</label>
                <input type="password" name="password" id="password" style="font-family: 'Rosarivo', cursive;" class="mt-1 block w-full rounded-md border-gray-300 shadow focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 p-2">
            </div>
            <div>
            <center>
                <button type="submit" name="login" class="w-1/3 flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium  focus:outline-none focus:ring-1 focus:ring-offset-1" style="font-family: 'Rosarivo', cursive; background-color: #CC9544;">
                    Log in
                </button>
            </center>
            </div>
        </form>
    </div>
</body>
</html>
