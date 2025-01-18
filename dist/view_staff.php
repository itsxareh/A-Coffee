<?php 
if (isset($_GET['id'])){
    $id = $_GET['id'];
    $select_staff = $conn->prepare("SELECT * FROM users WHERE id = ? AND delete_flag = 0");
    $select_staff->execute([$id]);
    $staff = $select_staff->fetch(PDO::FETCH_ASSOC); 

    if ($staff) {
?>
<div class="grid cols-grid-1 cols-grid-2 gap-4">
    <div class="flex items-center" style="min-height:400px; max-height: 500px;">
        <img class="w-full h-full object-cover rounded" src="../uploaded_img/<?= isset($staff['image']) ? $staff['image'] : ''; ?>">
    </div>
    <div class="flex items-start justify-center flex-col p-4">
        <div class="flex justify-between w-full">
            <div class="">
            <label class="text-white text-md font-medium leading-tight tracking-normal mt-2 block" for="name">Name</label>
            <span class="text-gray text-lg font-medium" id="name"><?= ucwords(isset($staff['name'])) ? ucwords( $staff['name']) : 'N/A'; ?></span>
            </div>
            <div class="">
                <label class="text-white text-md font-medium leading-tight tracking-normal mt-2 block" for="uid">UID</label>
                <span class="text-gray text-lg font-medium" id="uid"><?= isset($staff['uid']) ? $staff['uid'] : 'N/A'; ?></span>
            </div>
        </div>
        <label class="text-white text-md font-medium leading-tight tracking-normal mt-2" for="pnumber">Phone number</label>
        <span class="text-gray text-lg font-medium" id="pnumber"><?= isset($staff['pnumber']) ? '0'.$staff['pnumber'] : 'N/A'; ?></span>
        <label class="text-white text-md font-medium leading-tight tracking-normal mt-2" for="email">Email address</label>
        <span class="text-gray text-lg font-medium" id="email"><?= isset($staff['email']) ? $staff['email'] : 'N/A'; ?></span>
        <label class="text-white text-md font-medium leading-tight tracking-normal mt-2" for="gender">Gender</label>
        <span class="text-gray text-lg font-medium" id="gender"><?= ucwords(isset($staff['gender'])) ? ucwords($staff['gender']) : 'N/A'; ?></span>
        <label class="text-white text-md font-medium leading-tight tracking-normal mt-2" for="birthdate">Birthdate</label>
        <span class="text-gray text-lg font-medium" id="birthdate"><?= ucwords(isset($staff['birthdate'])) ? ucwords( $staff['birthdate']) : 'N/A'; ?></span>
        <label class="text-white text-md font-medium leading-tight tracking-normal mt-2" for="user_type">User type</label>
        <span class="text-gray text-lg font-medium" id="user_type"><?php switch($staff['user_type']){ case 0: echo 'Staff'; break; case 1: echo 'Admin'; break; default: echo 'N/A'; break; }?></span>
        <label class="text-white text-md font-medium leading-tight tracking-normal mt-2" for="address">Address</label>
        <span class="text-gray text-lg font-medium" id="address"><?= ucwords(isset($staff['address'])) ? ucwords($staff['address']) : 'N/A'; ?></span>
        <label class="text-white text-md font-medium leading-tight tracking-normal mt-2" for="joined_at">Joined at</label>
        <span class="text-gray text-lg font-medium" id="joined_at"><?= ucwords(isset($staff['joined_at'])) ? ucwords( $staff['joined_at']) : 'N/A'; ?></span>
    
    </div>
</div>
<?php 
    } else {
        echo "Staff not found.";
    }
}
?>
