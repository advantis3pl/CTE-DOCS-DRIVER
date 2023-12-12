<?php
include("../userAuth.php");

if(isset($_POST['id'])){
    $vehicleId = htmlspecialchars($_POST['id']);
    $vehicleId = mysqli_real_escape_string($conn, $vehicleId);

    $query = "SELECT * FROM driver WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $vehicleId);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){
        $driver = $result->fetch_assoc();
        $dname = $driver['name'];
        $dnic = $driver['nic'];
        $dphone = $driver['phone'];
        $dvehicle = $driver['vehicle'];
        $dbox = $driver['no_box'];
        $dparcel = $driver['no_parcel'];
        $dlogno = $driver['log_no'];

        $response = array(
            'requestStatus' => 200,
            'message' => 'Success!',
            'name' => $dname,
            'nic' => $dnic,
            'phone' => $dphone,
            'vehicle' => $dvehicle,
            'no_box' => $dbox,
            'no_parcel' => $dparcel,
            'log_no' => $dlogno
        );
        echo json_encode($response);

    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Failed to get vehicle details!'
        );
        echo json_encode($response);
    }
    
}

?>