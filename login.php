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
</head>

<body class="align">

  <div class="grid">

    <form method="post" class="form login">

        <header class="login__header">
            <h3 class="login__title">CTE Doc drive</h3>
        </header>

        <div class="login__body">

            <div class="form__field">
            <input type="text" placeholder="Username" name="username" class="w-100" required>
            </div>

            <div class="form__field">
            <input type="password" placeholder="Password" name="password" required>
            </div>

        </div>

        <footer class="login__footer">
            <input type="submit" value="Login" name="login">

            <p><span class="icon icon--info">?</span><a href="#">Forgot Password</a></p>
        </footer>

        <header class="login__header">
            © ADVANTIS 3PL BSS Team
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
            echo "<p class='text-danger text-center p-3'>User not found!</p>";
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
                    echo "<p class='text-danger text-center p-3'> Your Account is Deactivated. </p>";
                }
            
            } else {
                echo "<p class='text-danger text-center p-3'>Password is wrong!</p>";
            }
        }
    }

    ?>

  </div>

</body>

</html>