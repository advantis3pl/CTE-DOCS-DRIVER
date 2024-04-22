<?php

include("partials/navbar.php");


?>

<div class="profileContainer border p-4 mt-4">

    <p class="border-bottom p-2 font-bold">Profile</p>

    <table class="table table-striped">
        <tr>
            <td>Username : </td>
            <td><input type="text" class="form-control" name="profile_username" id="profile_username" value="<?php echo $username; ?>" readonly></td>
        </tr>
        <tr>
            <td>First name : </td>
            <td><input type="text" class="form-control" name="profile_firstname" id="profile_firstname" value="<?php echo $user_firstName; ?>"></td>
        </tr>
        <tr>
            <td>Last name : </td>
            <td><input type="text" class="form-control" name="profile_lastname" id="profile_lastname" value="<?php echo $user_lastName; ?>"></td>
        </tr>
    </table>

    <input type="text" hidden name="fixed_profile_username" id="fixed_profile_username" value="<?php echo $username; ?>">
    <input type="text" hidden name="fixed_profile_firstname" id="fixed_profile_firstname" value="<?php echo $user_firstName; ?>">
    <input type="text" hidden name="fixed_profile_lastname" id="fixed_profile_lastname" value="<?php echo $user_lastName; ?>">


    <div class="w-100 justify-content-between align-items-center d-flex">
        <div id="profile_details_error">

            <p class="text-danger"></p>

            <?php
            if(isset($_SESSION['profile_update_status'])){
                if($_SESSION['profile_update_status'] == "200"){
                    ?>
                    <p class="text-success">Profile Updated Successfully!</p>
                    <?php
                }else{
                    ?>
                    <p class="text-danger">Something went wrong!</p>
                    <?php
                }
                unset($_SESSION['profile_update_status']);
            }
            ?>

        </div>
        <div>
            <button class="btn btn-primary" onclick="updateProfileDetails()">Update</button>
            <button class="btn btn-success" onclick="profileResetChanges()">Reset</button>
        </div>
    </div>




    <p class="border-bottom p-2 font-bold">Security Settings</p>

    <table class="table table-striped">
        <tr>
            <td>Current Password : </td>
            <td><input type="password" class="form-control" name="profile_current_pass" id="profile_current_pass" placeholder="Enter your current password"></td>
        </tr>
        <tr>
            <td>New Password : </td>
            <td><input type="password" class="form-control" name="profile_new_pass" id="profile_new_pass" placeholder="Enter your new password"></td>
        </tr>
        <tr>
            <td>Confirm New Password : </td>
            <td><input type="password" class="form-control" name="profile_c_new_pass" id="profile_c_new_pass" placeholder="Confirm your new password"></td>
        </tr>
    </table>

    <div class="w-100 justify-content-between align-items-center d-flex">

        <div id="profile_password_error">
            <?php
            if(isset($_SESSION['profile_password_status'])){
                if($_SESSION['profile_password_status'] == "200"){
                    ?>
                    <p class="text-success">Profile Updated Successfully!</p>
                    <?php
                }else{
                    ?>
                    <p class="text-danger">Something went wrong!</p>
                    <?php
                }
                unset($_SESSION['profile_password_status']);
            }
            ?>
        </div>

        <div>
            <button class="btn btn-primary" onclick="updatePasswords()">Update Password</button>
        </div>
    </div>

    <p class="border-bottom p-2 mt-4 font-bold">Actions</p>

    <table class="table table-striped">
        <tr>
            <td>
                <strong>De-Activate Account</strong>
                <p class="text-secondary">This feature will deactivate your account, and you will not be able to log in. <br> Only admins can change your account status to active again.</p>
            </td>
            <td>
                <form action="Deactivate.php" method="POST">
                    <button class="btn btn-danger" type="submit" name="deactivate_submit">Deactivate Account</button>
                </form>
            </td>
        </tr>
        <tr>
            <td><strong>Logout</strong></td>
            <td>
                <form method="POST">
                    <button class="btn btn-danger" type="submit" name="logout">Logout</button>
                </form>
            </td>
        </tr>
    </table>




</div>

<form method="POST">
    <input type="text" hidden name="new_p_username" id="new_p_username">
    <input type="text" hidden name="new_p_firstname" id="new_p_firstname">
    <input type="text" hidden name="new_p_lastname" id="new_p_lastname">
    <input type="submit" hidden name="new_p_submit" id="new_p_submit">
</form>


<form action="userPasswordAuth.php" method="POST">
    <input type="text" hidden name="up_form_current" id="up_form_current">
    <input type="text" hidden name="up_form_pass" id="up_form_pass">
    <input type="text" hidden name="up_form_c_pass" id="up_form_c_pass">
    <input type="submit" hidden name="up_form_submit" id="up_form_submit">
</form>


<?php

if(isset($_POST['logout'])){
    session_destroy();
    ?>
    <script>
        window.location.replace("index.php");
    </script>
    <?php
}


if(isset($_POST['new_p_submit'])){

    $sql = "UPDATE user SET username = ?, firstName = ?, lastName = ? WHERE userKey = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sssi", $u_p_username, $u_p_firstname, $u_p_lastname, $userId);

    $u_p_username = htmlspecialchars($_POST['new_p_username']);
    $u_p_username = mysqli_real_escape_string($conn, $u_p_username);

    $u_p_firstname = htmlspecialchars($_POST['new_p_firstname']);
    $u_p_firstname = mysqli_real_escape_string($conn, $u_p_firstname);

    $u_p_lastname = htmlspecialchars($_POST['new_p_lastname']);
    $u_p_lastname = mysqli_real_escape_string($conn, $u_p_lastname);


    if ($stmt->execute()) {
        $_SESSION['profile_update_status'] = "200";
        ?>
        <script>
            window.location.replace("profile.php");
        </script>
        <?php
    } else {
        $_SESSION['profile_update_status'] = "500";
    }

}


?>

<?php

include("partials/footer.php");

?>