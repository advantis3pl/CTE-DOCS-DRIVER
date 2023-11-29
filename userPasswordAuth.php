<?php
session_start();
include("config/conn.php");


if(isset($_SESSION['user_id'])){

    $userId = $_SESSION['user_id'];
    
    $query = "SELECT * FROM user WHERE userKey = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows != 1) {

        session_destroy();
        ?>
        <script>
            window.location.replace("login.php")
        </script>
        <?php

    }else{
        $user = $result->fetch_assoc();
        $userId = $user['userKey'];
        $password = $user['password'];
    }

}else{
    session_destroy();
    ?>
    <script>
        window.location.replace("login.php")
    </script>
    <?php
}




if(isset($_POST['up_form_current']) &&
isset($_POST['up_form_pass']) &&
isset($_POST['up_form_c_pass'])){

    $currentPassword = htmlspecialchars($_POST['up_form_current']);
    $currentPassword = mysqli_real_escape_string($conn, $currentPassword);

    $newPassword = htmlspecialchars($_POST['up_form_pass']);
    $newPassword = mysqli_real_escape_string($conn, $newPassword);

    ?>
    
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Auth</title>
        <style>
            body{
                width: 100vw;
                height: 100vh;
                justify-content: center;
                align-items: center;
                display: flex;
                flex-direction: column;
            }
            p{
                margin: 10px 0 0 0;
                color: gray;
            }
            div{
                justify-content: center;
                align-items: center;
                display: flex;
                flex-direction: column;
            }
            img{
                width: 50px;
                height: 50px;
            }
            a{
                background-color: gray;
                padding: 10px 20px;
                border-radius: 10px;
                margin-top: 10px;
                color: white;
                font-size: .9em;
            }
        </style>
        <link rel="stylesheet" href="css/main.css?v=4">
    </head>
    <body>

    <?php
    
    if(password_verify($currentPassword, $password)){

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $q = "UPDATE user SET password = ? WHERE userKey = ?";
        $s = $conn->prepare($q);
        $s->bind_param('ss', $hashedPassword,$userId);

        if ($s->execute()) {
            ?>

            <div>
                <img src="images/success.png" alt="">
                <p>Password Updated Successfully!</p>
                <a href="profile.php">< Back to profile</a>
            </div>
            
            <?php
        } else {
            ?>

            <div>
                <img src="images/cross.png" alt="">
                <p>Something went wrong!</p>
                <a href="profile.php">< Back to profile</a>
            </div>
            
            <?php
        }

    }else{
        ?>

            <div>
                <img src="images/cross.png" alt="">
                <p>Something went wrong!</p>
                <a href="profile.php">< Back to profile</a>
            </div>

        <?php
    }
    
    ?>

        
    </body>
    </html>
    
    <?php
 
}else{
    echo "Access Denide!";
}


?>