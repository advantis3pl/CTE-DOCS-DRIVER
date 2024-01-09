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
    if ($result->num_rows == 1) {
        //success
        ?>
        <script>
            window.location.replace("home.php")
        </script>
        <?php

    }else{
        session_destroy();
    }

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css?v=1.1">

    <style>
        .imageContainer{
            width: 100%;
            justify-content: center;
            align-items:center;
            display: flex;
        }
        .imageContainer img{
            width: 90%;
            height: auto;
        }
    </style>

</head>



<body class="align">
    <div class="grid">
        <div class="imageContainer">
            <img src="images/logistics.png" alt="">
        </div>

        <form method="post" class="form login">

        <header class="p-2 bg-dark">
            <h3 class="login__title text-center font-bold text-light">CTE DOCS DRIVE</h3>
        </header>

        <div class="">

            <div class="">
                <input type="text" placeholder="Username" name="username" class="w-100" required>
            </div>

            <div class="">
                <input type="password" placeholder="Password" name="password" required>
            </div>

        </div>

        <footer class="login__footer justify-content-center align-item-center d-flex pt-2">
            <button class="btn btn-secondary w-50" name="login" type="submit">Login</button>
        </footer>

        <header class="p-2">
            <p class="text-secondary text-center">© ADVANTIS 3PL BSS Team</p>
        </header>

        </form>


        <?php

            if(isset($_POST['login'])){

                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);
                $username = mysqli_real_escape_string($conn, $username);
                $password = mysqli_real_escape_string($conn, $password);

                $query = "SELECT * FROM user WHERE username = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows === 0) {
                    echo "<p class='text-danger text-center p-1'>User not found!</p>";
                    exit();
                }else{
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {

                        if($user['status'] == "active"){

                            $userSK = $user['userKey'];

                            $_SESSION['user_id'] = $userSK;

                            $dateString = date("Y-m-d H:i:s");

                            $userllsql = "UPDATE user SET last_login=? WHERE userKey=?";
                            $userll_stmt = $conn->prepare($userllsql);
                            $userll_stmt->bind_param("ss", $dateString, $userSK);
                            $userll_stmt->execute();

                            $userLoginHistory = "INSERT INTO login_history(user_sk, username, login_time) VALUES (?, ?, ?)";
                            $userll_stmt = $conn->prepare($userLoginHistory);
                            $userll_stmt->bind_param("sss", $userSK, $username, $dateString);
                            $userll_stmt->execute();

                            ?>
                            <script>
                                window.location.replace("home.php")
                            </script>
                            <?php

                        }else{
                            echo "<p class='text-danger text-center p-1'> Your Account is Deactivated. </p>";
                        }
                    
                    } else {
                        echo "<p class='text-danger text-center p-1'>Password is wrong!</p>";
                    }
                }
            }

        ?>

    </div>    
</body>

</html>


<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

