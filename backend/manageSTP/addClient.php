<?php
include("../userAuth.php");

if(isset($_POST['clientID']) && 
isset($_POST['name']) && 
isset($_POST['address']) && 
isset($_POST['city']) && 
isset($_POST['route']) && 
isset($_POST['status'])){

    $clientID = htmlspecialchars($_POST['clientID']);
    $clientID = mysqli_real_escape_string($conn, $clientID);

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

    date_default_timezone_set('Asia/Colombo');
    $date = date("Y-m-d H:i:s");

    if($address == ""){
        $address = "n/a";
    }

    $query = "INSERT INTO client(code, name, city,address, route, status, added_by,added_date_time) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssisis', $clientID,$name,$city,$address,$route,$status,$userDbID,$date);
    if($stmt->execute()){
        $response = array(
            'requestStatus' => 200,
            'message' => 'Success!'
        );
        echo json_encode($response);
    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Failed to add client details!'
        );
        echo json_encode($response);
    }

}

?>