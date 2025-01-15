<?php
if (isset($_SESSION['uid'])){
    $select_profile = $conn->prepare("SELECT *, DATE_FORMAT(STR_TO_DATE(birthdate, '%m-%d-%Y'), '%Y-%m-%d') AS bdate FROM users WHERE uid = ?");
    $select_profile->bindParam(1, $_SESSION['uid']);
    $select_profile->execute();
    $profile = $select_profile->fetch(PDO::FETCH_ASSOC);     
}
?>
<div class="hide-message hidden">
    <div class="message rounded-lg p-4 flex items-start">
        <span id="message" class="text-sm text-white"></span>
        <button class="-m-1" onclick="this.parentElement.remove();"><img class="w-5 h-5" src="../images/close-svgrepo-com.svg"></button>
    </div>
</div>
<div class="flex items-center justify-center flex-col">
    <div class="max-w-xl relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
        <h1 class="text-gray-800 text-lg font-medium
            tracking-normal leading-tight mb-4 text-center">Profile Information</h1>
        <form id="update_user" action="update_user.php" method="POST" enctype="multipart/form-data">
            <input type="text" class="hidden" name="uid" id="uid" value="<?= $profile['uid'] ?>">
            <div class="mt-5 grid cols-grid-1 cols-grid-2 gap-x-2">
                <div class="col-span-full flex justify-center">
                    <div class="text-center">
                        <img id="previewImage" class="w-48 h-48 rounded-full bg-center object-cover" src="<?= $profile['image'] ?>">
                        <label class="relative cursor-pointer rounded-lg float-end" for="image">
                            <img class="w-6 h-6" src="../images/upload-minimalistic-svgrepo-com.svg">
                            <input id="image" name="image" class="sr-only" type="file" accept="image/jpg, image/jpeg, image/png" onchange="previewFile()">
                            <input type="hidden" name="old_image" id="old_image">
                        </label>
                    </div>
                </div>
                <div class="col-span-1">
                    <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="name">Name</label>
                    <input value="<?=ucwords($profile['name']) ?>" title="Name" name="name" id="name" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" placeholder="Juan Dela Cruz" type="text" autocomplete="off" required>
                </div>
                <div class="col-span-1">
                    <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="pnumber">Phone number</label>
                    <div class="relative mb-5 mt-2">
                        <div class="absolute text-gray-600 flex items-center px-2 border-r h-full">
                            <p class="text-sm text-gray-600 font-normal ">+63</p>
                        </div>
                        <input value="<?= $profile['pnumber'] ?>" title="Phone number" name="pnumber" id="pnumber" class="text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-12 text-sm border-gray-300 rounded border" placeholder="9123456789" />
                    </div>
                    <div id="pnumberError" class="text-red-500 salsa"></div>
                </div>
                <div class="col-span-1">
                    <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="gender">Gender</label>
                    <select title="Gender" name="gender" id="gender" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                        <option value="male" <?= $profile['gender'] === 'male' ? 'selected' : ''?>>Male</option> 
                        <option value="female" <?= $profile['gender'] === 'female' ? 'selected' : ''?>>Female</option>
                    </select>
                </div>
                <div class="col-span-1">
                    <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="email">Email address</label>
                    <input value="<?= $profile['email'] ?>" title="Email address" name="email" id="email" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-600 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" autocomplete="off" placeholder="juandelacruz@gmail.com" type="email" required>
                </div>
                <div class="col-span-1">
                    <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="password">Current Password</label>
                    <input title="Current Password" name="password" id="password" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" placeholder="********" type="password" autocomplete="off">
                    
                </div>
                <div class="col-span-1">
                    <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="birthdate">Birthdate</label>
                    <input value="<?= $profile['bdate'] ?>" title="Birthdate" name="birthdate" id="birthdate" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" type="date" required>
                </div>
                <div class="col-span-1">
                    <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="password">New Password</label>
                    <input title="New Password" name="npassword" id="npassword" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" placeholder="********" type="password" autocomplete="off">
                </div>
                <div class="col-span-1">
                    <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="usertype">User Type</label>
                    <select title="Usertype" name="usertype" id="usertype" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-400 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                        <option <?= $profile['user_type'] === 0 ? 'selected' : ''?> value="0">Staff</option> 
                        <option <?= $profile['user_type'] === 1 ? 'selected' : 'disabled'?> value="1">Manager</option>
                    </select>
                </div>
                <div class="col-span-full">
                    <label class="text-gray-800 text-sm font-medium leading-tight tracking-normal salsa" for="address">Address</label>
                    <input value="<?= $profile['address'] ? $profile['address'] : 'N/A' ?>" title="Address" name="address" id="address" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-amber-600 font-normal w-full flex items-center pl-3 py-2 text-sm border-gray-300 rounded border" rows="3" autocomplete="off" placeholder="12 Zamora St. Sampaloc, Manila City" required></input>
                </div>
            </div>
            <div class="flex items-center justify-center w-full">
                <button title="Update" type="submit" name="submit" id="submitBtn" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 transition duration-150 ease-in-out bg-light-brown rounded text-white px-8 py-2 text-sm">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
    const messages = document.getElementById("message");
    const divMessage = document.getElementsByClassName('hide-message')[0];
    const submitBtn = document.getElementById('submitBtn');
    const formElement = document.getElementById('update_user');
    const password = document.getElementById('password');
    const npassword = document.getElementById('npassword');


    submitBtn.addEventListener('click', submitForm);

    function submitForm(event){
        event.preventDefault();
        if (password.value === "" && npassword.value !== "") {
            messages.textContent = "Current password needed";
            if (divMessage) {
                divMessage.classList.remove('hidden');
            }
            setTimeout(() => {
                if (divMessage) {
                    divMessage.classList.add('hidden');
                }
            }, 2000);
            return; 
        }

        const formData = new FormData(formElement);
        
        fetch('update_user.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.update === true){
                document.getElementById('uid').value = data.uid;
                document.getElementById('name').value = data.name;
                document.getElementById('pnumber').value = data.pnumber;
                document.getElementById('gender').value = data.gender;
                document.getElementById('email').value = data.email;
                document.getElementById('birthdate').value = data.bdate;
                document.getElementById('usertype').value = data.user_type;
                document.getElementById('address').value = data.address;
                document.getElementById('old_image').value = data.image;
                document.getElementById('previewImage').src = data.image;
            }
            if (divMessage) {
                divMessage.classList.remove('hidden');
            }
            messages.textContent = data.message;
            setTimeout(function() {
                if (divMessage) {
                    divMessage.classList.add('hidden');
                }
            }, 1000);
        })
        .catch(error => { console.error('Error updating profile:', error)});
    }
</script>