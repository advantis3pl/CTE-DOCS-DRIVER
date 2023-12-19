<?php
include("../userAuth.php");

if(isset($_POST['driverId'])){

    $driver = htmlspecialchars($_POST['driverId']);
    $driver = mysqli_real_escape_string($conn, $driver);

    $query = "SELECT * FROM driver WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $driver);

    if($stmt->execute()){

        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $d = $result->fetch_assoc();
            $driverStatus = $d['isPrinted'];

            if($driverStatus == "true"){

                $response = array(
                    'requestStatus' => 200,
                    'message' => true
                );
                echo json_encode($response);

            }else{

                $response = array(
                    'requestStatus' => 200,
                    'message' => false
                );
                echo json_encode($response);

            }

        }else{
            $response = array(
                'requestStatus' => 500,
                'message' => 'Failed to update the vehicle!'
            );
            echo json_encode($response);
        }

    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Failed to update the vehicle!'
        );
        echo json_encode($response);
    }

}

?>