<?php
include("../userAuth.php");


if(isset($_POST['nic']) && 
isset($_POST['name']) && 
isset($_POST['phone']) && 
isset($_POST['vehicle']) && 
isset($_POST['box']) && 
isset($_POST['parcel']) && 
isset($_POST['log']) && 
isset($_POST['route'])){

    $nic = htmlspecialchars($_POST['nic']);
    $nic = mysqli_real_escape_string($conn, $nic);
    
    $name = htmlspecialchars($_POST['name']);
    $name = mysqli_real_escape_string($conn, $name);
    
    $phone = htmlspecialchars($_POST['phone']);
    $phone = mysqli_real_escape_string($conn, $phone);
    
    $vehicle = htmlspecialchars($_POST['vehicle']);
    $vehicle = mysqli_real_escape_string($conn, $vehicle);
    
    $box = htmlspecialchars($_POST['box']);
    $box = mysqli_real_escape_string($conn, $box);
    
    $parcel = htmlspecialchars($_POST['parcel']);
    $parcel = mysqli_real_escape_string($conn, $parcel);
    
    $log = htmlspecialchars($_POST['log']);
    $log = mysqli_real_escape_string($conn, $log);

    $currentRoute = htmlspecialchars($_POST['route']);
    $currentRoute = mysqli_real_escape_string($conn, $currentRoute);

    date_default_timezone_set('Asia/Colombo');
    $date = date('Y-n-j');
    $time = date('H:i:s');

    $q = "INSERT INTO driver(name, nic, phone,vehicle, no_box,
    no_parcel,log_no,created_date,created_time,added_by,route) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $s = $conn->prepare($q);
    $s->bind_param('ssisiisssii', $name,$nic,$phone,$vehicle,$box,$parcel,$log,$date,$time,$userDbID,$currentRoute);
    if($s->execute()){
        $lastInsertedId = $conn->insert_id;
        $response = array(
            'requestStatus' => 200,
            'message' => 'Vehicle Added Successfully!',
            'driverId' => $lastInsertedId
        );
        echo json_encode($response);
    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Failed to add the vehicle!'
        );
        echo json_encode($response);
    }

}


?>