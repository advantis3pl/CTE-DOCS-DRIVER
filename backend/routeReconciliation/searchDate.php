<?php
include("../userAuth.php");

if(isset($_POST['searchedDate'])){

    $date = htmlspecialchars($_POST['searchedDate']);
    $date = mysqli_real_escape_string($conn, $date);
    
    $dateTime = new DateTime($date);
    
    $formattedDate = $dateTime->format('Y-n-j');
    
    $vehicles = array(); 
    $assigned = array();
    $returnsArray = array();
    $errorFlag = false; 

    $query = "SELECT * FROM driver WHERE printedDate = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $formattedDate);
    if($stmt->execute()){
        
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $vehicles[] = $row;

            $vehicleId = $row['id'];

            $q = "SELECT * FROM delivery WHERE driverId = ?";
            $s = $conn->prepare($q);
            $s->bind_param('i', $vehicleId);
            if($s->execute()){
                $r = $s->get_result();
                while($delivery = $r->fetch_assoc()){
                    $assigned[] = $delivery;
                }
            }else{
                //error
                $errorFlag = true; 
            }


            $q_return = "SELECT * FROM return_record WHERE vehicle = ?";
            $s_return = $conn->prepare($q_return);
            $s_return->bind_param('i', $vehicleId);
            if($s_return->execute()){
                $r_return = $s_return->get_result();
                while($retun = $r_return->fetch_assoc()){
                    $returnsArray[] = $retun;
                }
            }else{
                //error
                $errorFlag = true; 
            }

        }

    }else{
        //error
        $errorFlag = true; 
    }

    $vehiclesString = json_encode($vehicles);
    $assignedString = json_encode($assigned);
    $returnsString = json_encode($returnsArray);

    if($errorFlag == false){
        $response = array(
            'requestStatus' => 200,
            'message' => 'Success!',
            'vehicles' => $vehiclesString,
            'assigned' => $assignedString,
            'returns' => $returnsString
        );
        echo json_encode($response);
    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Success!',
            'vehicles' => 'none',
            'assigned' => 'none'
        );
        echo json_encode($response);
    }
    
}

?>