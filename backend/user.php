<?php

include("adminAuth.php");

if(isset($_POST['userNameValidation'])){

    $username = htmlspecialchars($_POST['userNameValidation']);
    $username = mysqli_real_escape_string($conn, $username);

    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo "200";
    }else{
        echo "500";
    }

}



if( isset($_POST['fname']) && 
    isset($_POST['lname']) && 
    isset($_POST['username']) && 
    isset($_POST['usertype']) && 
    isset($_POST['status']) &&
    isset($_POST['password'])) {

    
    $fname = htmlspecialchars($_POST['fname']);
    $fname = mysqli_real_escape_string($conn, $fname);

    $lname = htmlspecialchars($_POST['lname']);
    $lname = mysqli_real_escape_string($conn, $lname);

    $username = htmlspecialchars($_POST['username']);
    $username = mysqli_real_escape_string($conn, $username);

    $usertype = htmlspecialchars($_POST['usertype']);
    $usertype = mysqli_real_escape_string($conn, $usertype);

    $password = htmlspecialchars($_POST['password']);
    $password = mysqli_real_escape_string($conn, $password);

    $status = htmlspecialchars($_POST['status']);
    $status = mysqli_real_escape_string($conn, $status);

    $password = password_hash($password, PASSWORD_DEFAULT);

    $uniqueID = md5(uniqid());
    $createdBy = $userId;

    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');

    $last_login = "not_yet";

    $query = "INSERT INTO user(username, password, type,firstName, lastName, userKey, createdby,date,time,status,last_login) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssssssss', $username,$password,$usertype,$fname,$lname,$uniqueID,$createdBy,$currentDate,$currentTime,$status,$last_login);
    if($stmt->execute()){
        echo "200";
    }else{
        echo "500";
    }

}




if( isset($_POST['fname']) && 
    isset($_POST['lname']) && 
    isset($_POST['username']) && 
    isset($_POST['usertype']) && 
    isset($_POST['status']) &&
    isset($_POST['action']) &&
    isset($_POST['selectedUserId'])) {

        $fname = htmlspecialchars($_POST['fname']);
        $fname = mysqli_real_escape_string($conn, $fname);

        $lname = htmlspecialchars($_POST['lname']);
        $lname = mysqli_real_escape_string($conn, $lname);

        $username = htmlspecialchars($_POST['username']);
        $username = mysqli_real_escape_string($conn, $username);

        $type = htmlspecialchars($_POST['usertype']);
        $type = mysqli_real_escape_string($conn, $type);

        $status = htmlspecialchars($_POST['status']);
        $status = mysqli_real_escape_string($conn, $status);
        
        $selectedUserId = htmlspecialchars($_POST['selectedUserId']);
        $selectedUserId = mysqli_real_escape_string($conn, $selectedUserId);

        $query = "UPDATE user SET username = ?, type = ?, firstName = ?, lastName = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssi', $username,$type,$fname,$lname,$status,$selectedUserId);
        if($stmt->execute()){
            echo "200";
        }else{
            echo "500";
        }

    }




?>