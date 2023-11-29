<?php

include("partials/navbar.php");
include("partials/adminAuth.php");

$admin_userId = htmlspecialchars($_SESSION['user_id']);
$admin_userId = mysqli_real_escape_string($conn, $admin_userId);

if(isset($_POST['vu_admin_password']) && isset($_POST['vu_s_settings_submit'])
&& isset($_POST['vu_selected_userid_admin'])){

    $selectedUserId = htmlspecialchars($_POST['vu_selected_userid_admin']);
    $selectedUserId = mysqli_real_escape_string($conn, $selectedUserId);

    $adminPassword = htmlspecialchars($_POST['vu_admin_password']);
    $adminPassword = mysqli_real_escape_string($conn, $adminPassword);

    $query = "SELECT * FROM user WHERE userKey = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $admin_userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if(password_verify($adminPassword, $admin['password'])){

        
        $q = "SELECT * FROM user WHERE id = ?";
        $s = $conn->prepare($q);
        $s->bind_param('s', $selectedUserId);
        $s->execute();
        $res = $s->get_result();
        if ($res->num_rows === 1) {
            $u = $res->fetch_assoc();

            ?>
            

            <form method="POST" action="backend/ProcessPassword.php">

                <div>
                    <h5 class="text-center border-bottom p-4">Change Password</h5>
                    <table class="table mb-3">

                        <tr>
                            <td>New Password</td>
                            <td class="tableRowData"><input type="password" name="ss_password" id="ss_password" required></td>
                        </tr>

                        <tr>
                            <td>Confirm New Password</td>
                            <td class="tableRowData"><input type="password" name="ss_confirm_password" id="ss_confirm_password" required></td>
                        </tr>
                    </table>

                    <div class="justify-content-between align-items-center d-flex">
                        <p></p>
                        <div>
                            <input type="text" hidden name="selectedUserId" id="selectedUserId" value="<?php echo $selectedUserId; ?>">
                            <input type="submit" class="btn btn-success" name="ss_submit_btn" value="Update">
                            <a href="users.php" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>

            </form>
            
            
            <?php

        }else{
            ?>
            <p class="text-secondary p-4">User not found!</p>
            <?php
        }


    }else{
        ?>
        <p class="text-secondary p-4">Access Error!</p>
        <?php
    }

}else{
    ?>
    <p class="text-secondary p-4">Access Error!</p>
    <?php
}
?>


<?php
include("partials/footer.php");
?>
