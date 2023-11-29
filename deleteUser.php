<?php

include("partials/navbar.php");
include("partials/adminAuth.php");


if(isset($_POST['du_userID'])){

    $du_userId = htmlspecialchars($_POST['du_userID']);
    $du_userId = mysqli_real_escape_string($conn, $du_userId);

    $query = "SELECT * FROM user WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $du_userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {

        $sql = "DELETE FROM user WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $du_userId);

        if($stmt->execute()){

            ?>
            
            <div class="w-100 justify-content-center align-items-center d-flex flex-column">
                <img src="images/success.png" alt="" width="50" height="50">
                <p class="text-secondary pt-4">User Deleted Successfully!</p>
                <a class="btn btn-success" href="users.php">Back</a>
            </div>
            
            <?php

        }else{

            ?>
            
                        
            <div class="w-100 justify-content-center align-items-center d-flex flex-column">
                <img src="images/cross.png" alt="" width="50" height="50">
                <p class="text-secondary pt-4">Something went wrong!</p>
                <a class="btn btn-success" href="users.php">Back</a>
            </div>

            
            <?php
            
        }
        

    }else{

        ?>
        
        <div class="w-100 justify-content-center align-items-center d-flex flex-column">
            <img src="images/cross.png" alt="" width="50" height="50">
            <p class="text-secondary pt-4">User not found!</p>
            <a class="btn btn-success" href="users.php">Back</a>
        </div>
        
        <?php

    }

}else{
    ?>
    <p class="text-secondary p-4">Access Error!</p>
    <?php
}

include("partials/footer.php");
?>