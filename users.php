<?php

include("partials/navbar.php");
include("partials/adminAuth.php");

?>


<div class="popUpContainer" id="addUserPopUp">
    <div class="popUpWindow popUpGONE" id="popUpWindow">

        <div class="popUpLoader" id="auPopUpLoader">
            <img src="images/loader.gif" alt="" width="50" height="50">
            <p>Processing...</p>
        </div>

        <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
            <h5>Add User</h5>
            <button class="btn btn-danger" onclick="closeUserPopUp()">X</button>
        </div>

        <form post="POST">
            <table class="mt-3">
                <tr>
                    <td class="d-flex tableRowName">First Name </td>
                    <td class="tableRowData"><input type="text" name="au_fname" id="au_fname"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Last Name </td>
                    <td class="tableRowData"><input type="text" name="au_lname" id="au_lname"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Username </td>
                    <td class="tableRowData"><input type="text" name="au_username" id="au_username"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">User type </td>
                    <td class="tableRowData">
                        <select name="au_usertype" id="au_usertype" class="form-control">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Password </td>
                    <td class="tableRowData"><input type="password" name="au_password" id="au_password"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Confirm Password </td>
                    <td class="tableRowData"><input type="password" name="au_cpassword" id="au_cpassword"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Status </td>
                    <td class="tableRowData">
                        <select name="au_status" id="au_status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </td>
                </tr>
            </table>  
            
            <p class="text-danger text-right" id="auFormError"></p>

            <div class="d-flex justify-content-between align-items-center border-top mt-3 pt-3">
                <p></p>
                <div>
                    <button type="button" class="btn btn-success" onclick="addUser()">Add</button>
                    <button type="button" class="btn btn-secondary" onclick="closeUserPopUp()">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="popUpContainer" id="viewUserPopUp">
    <div class="popUpWindow popUpGONE" id="popUpWindow">

        <div class="popUpLoader" id="vuPopUpLoader">
            <img src="images/loader.gif" alt="" width="50" height="50">
            <p>Processing...</p>
        </div>

        <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
            <h5>Add User</h5>
            <button class="btn btn-danger" onclick="closeVUForm()">X</button>
        </div>

        <form post="POST">
            <table class="mt-3">
                <tr>
                    <td class="d-flex tableRowName">First Name </td>
                    <td class="tableRowData"><input type="text" name="vu_fname" id="vu_fname"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Last Name </td>
                    <td class="tableRowData"><input type="text" name="vu_lname" id="vu_lname"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Username </td>
                    <td class="tableRowData"><input type="text" name="vu_username" id="vu_username"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">User type </td>
                    <td class="tableRowData">
                        <select name="vu_usertype" id="vu_usertype" class="form-control">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Status </td>
                    <td class="tableRowData">
                        <select name="vu_status" id="vu_status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="d-flex tableRowName">Last Login </td>
                    <td class="tableRowData"><input type="text" name="vu_last_login" id="vu_last_login" readonly></td>
                </tr>
            </table>    

            
            <p class="text-danger text-right" id="vuFormError"></p>

            <div class="d-flex justify-content-between align-items-center border-top mt-3 pt-3">
                <p></p>
                <div>
                    <a class="m-2 pointer" onclick="loginHistory()">Login History</a>
                    <a class="m-2 pointer" onclick="actionHistory()">Action History</a>
                    <button type="button" class="btn btn-primary" onclick="updateUserDetails()">Update</button>
                    <button type="button" class="btn btn-danger" onclick="userDeleteWindow()">Remove</button>
                    <button type="button" class="btn btn-success" onclick="resetVUuserDetails()">Reset</button>
                    <button type="button" class="btn btn-secondary" onclick="closeVUForm()">Close</button>
                </div>
            </div>


            <table>
                <tr class="border-top pt-3 pb-1">
                    <td colspan="2" class="text-secondary">Security Settings</td>
                </tr>
                <tr class="border-top pt-3">
                    <td class="d-flex tableRowName text-secondary">Admin Password</td>
                    <td class="tableRowData">
                        <input type="text" name="vu_admin_pass" id="vu_admin_pass">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><td><button type="button" class="btn btn-secondary" onclick="openSecuritySettings()">Settings</button></td></td>
                </tr>
            </table>

            <input type="text" hidden name="vu_selectedUserId" id="vu_selectedUserId">
            <input type="text" hidden name="vu_fixed_fname" id="vu_fixed_fname">
            <input type="text" hidden name="vu_fixed_lname" id="vu_fixed_lname">
            <input type="text" hidden name="vu_fixed_username" id="vu_fixed_username">
            <input type="text" hidden name="vu_fixed_usertype" id="vu_fixed_usertype">
            <input type="text" hidden name="vu_fixed_status" id="vu_fixed_status">
            
            <input type="text" hidden name="au_formChanges" id="au_formChanges" value="0">

        </form>
    </div>
</div>

<div class="popUpContainer" id="viewDeleteUser">
    <div class="popUpWindow popUpGONE" id="popUpWindow">
        <p id="delteUserText">Delete User?</p>
        <button class="btn btn-danger" onclick="deleteUserFromSystem()">Delete</button>
        <button class="btn btn-primary" onclick="backFromUserDelete()">Back</button>
    </div>
</div>


<div class="border-bottom p-2 justify-content-between align-items-center d-flex">
    <h6>Users</h6>
    <button class="btn btn-success" onclick="addUserPopUp()">Add User</button>
</div>

<!--
    username, firstname, lastname, usertype
-->

<table class="w-100 table table-bordered table-striped">
    <thead class="bg-info">
        <tr>
            <th class="font-bold text-center">Id</th>
            <th class="font-bold text-center">Username</th>
            <th class="font-bold text-center">First Name</th>
            <th class="font-bold text-center">Last Name</th>
            <th class="font-bold text-center">Usertype</th>   
            <th class="font-bold text-center">Created By</th>
            <th class="font-bold text-center">Created Date</th>  
            <th class="font-bold text-center">Created Time</th>
            <th class="font-bold text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $counter = 1;
        $query = "SELECT * FROM user";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {

            $q = "SELECT username FROM user WHERE userKey = ?";
            $s = $conn->prepare($q);
            $s->bind_param('s', $row['userKey']);
            $s->execute();
            $r = $s->get_result();
            if ($usernameRow = $r->fetch_assoc()) {
                $createdUsername = $usernameRow['username'];
            }

            ?>
            
            <tr>
                <td class="text-center"><?php echo $counter; ?></td>
                <td class="text-center"><?php echo $row['username']; ?></td>
                <td class="text-center"><?php echo $row['firstName']; ?></td>
                <td class="text-center"><?php echo $row['lastName']; ?></td>
                <td class="text-center"><?php echo $row['type']; ?></td>   
                <td class="text-center"><?php echo $createdUsername; ?></td>
                <td class="text-center"><?php echo $row['date']; ?></td>
                <td class="text-center"><?php echo $row['time']; ?></td>
                <td class="text-center">
                    <i class="table_icons bx bx-edit" onclick="editUserPopUp('<?php echo $row['id']; ?>','<?php echo $row['firstName']; ?>','<?php echo $row['lastName']; ?>','<?php echo $row['username']; ?>','<?php echo $row['type']; ?>','<?php echo $row['status']; ?>','<?php echo $row['last_login']; ?>')"></i>
                </td>
            </tr>
            
            <?php
            $counter++;
        }
        ?>
    </tbody>
</table>


<form action="deleteUser.php" method="POST">
    <input type="text" hidden name="du_userID" id="du_userID">
    <input type="submit" hidden name="du_submit" id="du_submit">
</form>

<form action="securitySettings.php" method="POST">
    <input type="text" hidden name="vu_admin_password" id="vu_admin_password">
    <input type="text" hidden name="vu_selected_userid_admin" id="vu_selected_userid_admin">
    <input type="submit" hidden name="vu_s_settings_submit" id="vu_s_settings_submit">
</form>

<?php
include("partials/footer.php");
?>