<?php
include("../userAuth.php");


if(isset($_POST['nic']) && 
isset($_POST['name']) && 
isset($_POST['phone']) && 
isset($_POST['vehicle']) && 
isset($_POST['box']) && 
isset($_POST['parcel']) && 
isset($_POST['log']) && 
isset($_POST['driverId'])){

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

    $driverId = htmlspecialchars($_POST['driverId']);
    $driverId = mysqli_real_escape_string($conn, $driverId);


    $q = "UPDATE driver SET name = ?, nic = ?, phone = ?, vehicle = ?, no_box = ?,no_parcel = ?, log_no = ? WHERE id = ?";
    $s = $conn->prepare($q);
    $s->bind_param('ssissssi', $name,$nic,$phone,$vehicle,$box,$parcel,$log,$driverId);
    if($s->execute()){
        $response = array(
            'requestStatus' => 200,
            'message' => 'Updated Added Successfully!'
        );
        echo json_encode($response);
    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Failed to update the vehicle!'
        );
        echo json_encode($response);
    }

}


?>