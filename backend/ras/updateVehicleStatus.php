<?php
include("../userAuth.php");

if(isset($_POST['selectedVehicle'])){
    $driver = htmlspecialchars($_POST['selectedVehicle']);
    $driver = mysqli_real_escape_string($conn, $driver);

    $query = "SELECT * FROM driver WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i',$driver);
    if($stmt->execute()){

        $result = $stmt->get_result();
        if ($result->num_rows == 1) {

            $data = $result->fetch_assoc();
            $isPrinted = $data['isPrinted'];

            if($isPrinted == "false"){

                $true = "true";
                date_default_timezone_set('Asia/Colombo');
                $date = date('Y-n-j');
                $time = date('H:i:s');
            
                $q = "UPDATE driver SET isPrinted = ?, printedDate = ?, printedTime = ? WHERE id = ?";
                $s = $conn->prepare($q);
                $s->bind_param('sssi', $true,$date,$time,$driver);
                if($s->execute()){
                    $response = array(
                        'requestStatus' => 200,
                        'message' => 'Updated Successfully!'
                    );
                    echo json_encode($response);
                }else{
                    $response = array(
                        'requestStatus' => 500,
                        'message' => 'Failed to update the vehicle!'
                    );
                    echo json_encode($response);
                }

            }else{

                $response = array(
                    'requestStatus' => 200,
                    'message' => 'Already Updated!'
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