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
        $userDbId = $user['id'];
        $username = $user['username'];
        $user_firstName = $user['firstName'];
        $user_lastName = $user['lastName'];
        $usertype = $user['type'];
        $user_lastLogin = $user['last_login'];
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTE</title>

    <link rel="stylesheet" href="css/main.css?v=4">
    <link rel="stylesheet" href="css/navbar.css?v=4" />
    <link rel="stylesheet" href="css/upload.css?v=1.5" />
    <link rel="stylesheet" href="css/home.css?v=4" />
    <link rel="stylesheet" href="css/cards.css?v=1.5" />
    <link rel="stylesheet" href="css/profile.css" />
    <link rel="stylesheet" href="css/ras.css?v=4.5" />
    <link rel="stylesheet" href="css/stpReport.css?v=2" />
    <link rel="stylesheet" href="css/manageStp.css?v=2" />
    <link rel="stylesheet" href="css/routeReconciliation.css" />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Slabo+27px|Yesteryear">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.0/css/bootstrap.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,300italic,400italic,600italic">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.0/js/bootstrap.min.js"></script>
    
    <!--for html to pdf-->
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

    <script src="js/main.js?v=7"></script>
    <script src="js/upload.js"></script>
    <script src="js/home.js"></script>
    <script src="js/nav.js"></script>
    <script src="js/cards.js?v=1.2"></script>
    <script src="js/ras.js?v=5"></script>
    <script src="js/user.js?v=4"></script>
    <script src="js/profile.js?v=2"></script>
    <script src="js/manageStp.js?v=2"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>


</head>
<body>
    <div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column navClose" id="sidebar">
        
        <ul class="nav flex-column text-white w-100">

        <a href="home.php" class="nav-link h3 text-white my-2">
            CTE DOCS Driver
        </a>

        <a href="home.php" class="text-white font-underline-none">
            <li class="nav-link">
                <i class="bx bxs-dashboard text-white"></i>
                <span class="mx-2 text-white">Home</span>
            </li>
        </a>


        <div class="navBreaker"></div>


        <?php
        if($usertype == "admin"){

            ?>
            <div class="navbarTopic">Admin</div>

            <a href="users.php" class="text-white font-underline-none">
                <li class="nav-link">
                    <i class="bx bx-user text-white"></i>
                    <span class="mx-2 text-white">Users</span>
                </li>
            </a>

            <div class="navBreaker"></div>
            <?php
            
        }
        ?>


        <div class="navbarTopic">RAS Module</div>
        <a href="manageStp.php" class="text-white font-underline-none">
            <li class="nav-link">
                <i class="bx bx-user text-white"></i>
                <span class="mx-2 text-white">Manage STP</span>
            </li>
        </a>

        <a href="upload.php" class="text-white font-underline-none">
            <li class="nav-link">
                <i class="bx bx-upload text-white"></i>
                <span class="mx-2 text-white">Upload Reports</span>
            </li>
        </a>

        <a href="ras.php" class="text-white font-underline-none">
            <li class="nav-link">
                <i class="bx bx-directions text-white"></i>
                <span class="mx-2 text-white">RAS</span>
            </li>
        </a>

        <a href="routeReconciliation.php" class="text-white font-underline-none">
            <li class="nav-link">
                <i class="bx bx-car text-white"></i>
                <span class="mx-2 text-white">Route Reconciliation</span>
            </li>
        </a>

        <a href="updatePending.php" class="text-white font-underline-none">
            <li class="nav-link">
                <i class="bx bx-upload text-white"></i>
                <span class="mx-2 text-white">Update Pending Delivery</span>
            </li>
        </a>

        <a href="deliveryHistory.php" class="text-white font-underline-none">
            <li class="nav-link">
                <i class="bx bx-download text-white"></i>
                <span class="mx-2 text-white">Delivery History</span>
            </li>
        </a>

        <a href="stpReports.php" class="text-white font-underline-none">
            <li class="nav-link">
                <i class="bx bx-download text-white"></i>
                <span class="mx-2 text-white">STP Reports</span>
            </li>
        </a>
        
        <div class="navBreaker"></div>

        <div class="navbarTopic">Personal Info</div>
        <a href="profile.php" class="text-white font-underline-none">
            <li class="nav-link">
                <i class="bx bx-user-check text-white"></i>
                <span class="mx-2 text-white">Profile</span>
            </li>
        </a>
        
        </ul>
    </div>

    <div class="my-container deactive-cont" id="mainContainer">

    <!--sub nav bar-->
    <div class="bg-light border-bottom subNavBar1111">
        <div class="mb-2 d-flex justify-content-between align-items-center">
            <div class="d-flex"> 
                <button class="btn btn-secondary" onclick="navOpCl()" id="navButton">
                    >
                </button>
                <div class="cteLogo">CTE DOCS DRIVER</div>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <b class="p-2"><?php echo $username; ?></b> 
                <a href="profile.php"><button class="btn btn-secondary m-1"><i class="bx bx-user text-light"></i></button></a>
                <a href="home.php"><button class="btn btn-secondary m-1"><i class="bx bx-home text-light"></i></button></a>
                <a href="logout.php"><button class="btn btn-secondary m-1"><i class="bx bx-log-out text-light"></i></button></a>
            </div>
        </div>
        <input type="text" hidden id="isNavOpen" value="0">
    </div>
