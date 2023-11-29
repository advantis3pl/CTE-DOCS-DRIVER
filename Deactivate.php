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
        $username = $user['username'];
    }

}else{
    session_destroy();
    ?>
    <script>
        window.location.replace("login.php")
    </script>
    <?php
}




if(isset($_POST['deactivate_submit'])){

    ?>
    
    

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>De-Activate</title>

        <style>
            body{
                justify-content: center;
                align-items: center;
                display: flex;
                flex-direction: column;
                width: 100vw;
                height: 100vh;
            }
            .container{
                width: 400px;
                height: fit-content;
                border: 1px solid gray;
            }
            h3{
                background: #dc3545;
                padding: 20px;
                color: white;
                font-weight: normal;
            }
            p{
                color: gray;
                padding: 20px;
            }
            .warnings{
                color: red;
            }
            .btn-warning{
                background-color: #dc3545;
                padding: 8px;
                text-align: center;
                width: 100%;
                color: white;
                border-radius: 5px;
                border: 1px solid #dc3545;
                cursor: pointer;
                width: 90%;
                margin-bottom: 5px;
                transition: .2s all linear;
            }
            .btn-warning:hover{
                background: #ab1a28;
            }
            .btn-cancel{
                background-color: gray;
                padding: 8px;
                text-align: center;
                width: 100%;
                color: white;
                border-radius: 5px;
                border: 1px solid gray;
                cursor: pointer;
                width: 90%;
                transition: .2s all linear;
            }
            .btn-cancel:hover{
                background: #4a4a4a;
            }
            .btn-container{
                justify-content: center;
                align-items:center;
                display: flex;
                flex-direction: column;
                padding: 20px;
            }

            .btn-container form{
                width: 100%;
                justify-content: center;
                align-items:center;
                display: flex;
            }

        </style>

        <script>
            function cancelRequest(){
                window.location.replace("profile.php");
            }
        </script>

    </head>
    <link rel="stylesheet" href="css/main.css?v=4">
    <body>

    <div class="container">

        <h3>Deactivate Account</h3>

        <p>Username : <?php echo $username; ?></p>

        <p><strong>Account Deactivation Warning:</strong></p>
        <p class="warnings">This action will deactivate your account, preventing further logins. </p>
        <p class="warnings"><strong>Note:</strong> Only administrators have the authority to reactivate your account.</p>
        
        <div class="btn-container">
            <form action="ConfirmDeactivation.php" method="POST">
                <input type="text" hidden name="deactive_userId" value="<?php echo $userId; ?>">
                <input type="text" hidden name="deactive_username" value="<?php echo $username; ?>">
                <input type="submit" value="Confirm" class="btn-warning" name="deactive_confirm">
            </form>
            <button class="btn-cancel" onclick="cancelRequest()">Cancel</button>
        </div>
        

    </div>
        
    </body>
    </html>
    
    
    
    <?php

}else{
    echo "Access Denide!";
}


?>