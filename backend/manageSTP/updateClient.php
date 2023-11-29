<?php
include("../userAuth.php");

if(isset($_POST['clientDBId']) &&
isset($_POST['clientID']) &&
isset($_POST['name']) &&
isset($_POST['address']) &&
isset($_POST['city']) &&
isset($_POST['route']) &&
isset($_POST['status'])){

    $clientDBId = htmlspecialchars($_POST['clientDBId']);
    $clientDBId = mysqli_real_escape_string($conn, $clientDBId);

    $code = htmlspecialchars($_POST['clientID']);
    $code = mysqli_real_escape_string($conn, $code);

    $name = htmlspecialchars($_POST['name']);
    $name = mysqli_real_escape_string($conn, $name);

    $address = htmlspecialchars($_POST['address']);
    $address = mysqli_real_escape_string($conn, $address);

    $city = htmlspecialchars($_POST['city']);
    $city = mysqli_real_escape_string($conn, $city);

    $route = htmlspecialchars($_POST['route']);
    $route = mysqli_real_escape_string($conn, $route);

    $status = htmlspecialchars($_POST['status']);
    $status = mysqli_real_escape_string($conn, $status);

    $query = "UPDATE client SET code = ?, name = ?, city = ?, address = ?, route = ?,status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssssi', $code,$name,$city,$address,$route,$status,$clientDBId);
    if($stmt->execute()){
        $response = array(
            'requestStatus' => 200,
            'message' => 'Success!'
        );
        echo json_encode($response);
    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Something went wrong!'
        );
        echo json_encode($response);
    }
}

?>