<?php
include("adminAuth.php");
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth</title>
    <link rel="stylesheet" href="../css/main.css?v=4">
</head>

<style>
    body{
        width: 100vw;
        height: 100vh;
        justify-content: center;
        align-items: center;
        display: flex;
        flex-direction: column;
    }
    .card{
        justify-content: center;
        align-items: center;
        display: flex;
        border: 1px solid gray;
        border-radius: 10px;
        padding: 20px;
    }
    .card img{
        margin: 0 20px 0 0;
    }
    .cardText p{
        margin: 0 0 10px 0;
    }
</style>

<body>

<?php


if(isset($_POST['ss_password']) && 
isset($_POST['ss_confirm_password']) && 
isset($_POST['selectedUserId']) && 
isset($_POST['ss_submit_btn'])){

    $password = $_POST['ss_password'];
    $confirmPassword = $_POST['ss_confirm_password'];
    $selectedUserId = $_POST['selectedUserId'];

    if($password == $confirmPassword){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE user SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashedPassword, $selectedUserId);
        
        if($stmt->execute()){

            ?>
            <div class="card">
                <img src="../images/success.png" alt="" width="50" height="50">
                <div class="cardText">
                    <p>Password Changed!</p>
                    <a href="../users.php">Back to Users</a>
                </div>
            </div>
            
            <?php

        }else{

            ?>
            <div class="card">
                <img src="../images/cross.png" alt="" width="50" height="50">
                <div class="cardText">
                    <p>Server error. Try again!</p>
                    <a href="../users.php">Back to Users</a>
                </div>
            </div>
            
            <?php

        }

    }else{

        ?>
        <div class="card">
            <img src="../images/cross.png" alt="" width="50" height="50">
            <div class="cardText">
                <p>Passwords not matched!</p>
                <a href="../users.php">Back to Users</a>
            </div>
        </div>
        
        <?php

    }

}else{

    ?>
    <div class="card">
        <img src="../images/cross.png" alt="" width="50" height="50">
        <div class="cardText">
            <p>Something went wrong!</p>
            <a href="../users.php">Back to Users</a>
        </div>
    </div>
    
    <?php

}


?>
    
</body>
</html>