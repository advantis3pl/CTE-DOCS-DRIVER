<?php

session_start();
include("config/conn.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        .loadingCon{
            width: 100%;
            height: 100vh;
            justify-content: center;
            align-items: center;
            display: flex;
        }
    </style>
</head>
<body>

    <div class="loadingCon">
        <img src="images/advantis.png" width="150" height="27" alt="" class="mb-1">
        <img src="images/loader.gif" width="50" height="50" alt="">
    </div>
    
</body>
</html>

<?php
    if(isset($_SESSION['user_id'])){

        $userId = $_SESSION['user_id'];
        
        $query = "SELECT * FROM user WHERE userKey = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {

            //success
            ?>
            <script>
                window.location.replace("home.php")
            </script>
            <?php

        }else{
            session_destroy();
            ?>
            <script>
                window.location.replace("login.php")
            </script>
            <?php
        }

    }else{
        session_destroy();
        ?>
        <script>
            window.location.replace("login.php")
        </script>
        <?php
    }
?>
