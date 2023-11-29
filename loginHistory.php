<?php

include("partials/navbar.php");
include("partials/adminAuth.php");

if(isset($_GET['id'])){
    $history_username = $_GET['id'];

    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $history_username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {

        ?>
        
        <div class="justify-content-center align-items-center d-flex">

            <div class="w-75">
                <h4>Login History (<?php echo $history_username; ?>) <a href="users.php"> < Back to Users</a></h4>
                <table class="table">
                    <tr>
                        <td class="font-bold">Username</td>
                        <td class="font-bold">Login Time</td>
                    </tr>

                    <?php
                    
                    $q = "SELECT * FROM login_history WHERE username = ?";
                    $s = $conn->prepare($q);
                    $s->bind_param('s', $history_username);
                    $s->execute();
                    $r = $s->get_result();
                    while ($row = $r->fetch_assoc()) {
                        ?>

                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['login_time']; ?></td>
                        </tr>
                        
                        <?php
                    }
                    
                    ?>

                </table>

            </div>
    
        </div>

        
        
        <?php

    }else{
        ?>
        <p class="text-secondary p-4">Error! User not found.</p>
        <?php
    }

}else{
    ?>
    <p class="text-secondary p-4">Error! User not found.</p>
    <?php
}

?>


<?php
include("partials/footer.php");
?>