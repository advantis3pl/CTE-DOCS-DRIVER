<?php
include("../userAuth.php");


if(isset($_POST['deliveryNumber']) && isset($_POST['selectedRoute']) && isset($_POST['driver'])){

    $dno = htmlspecialchars($_POST['deliveryNumber']);
    $dno = mysqli_real_escape_string($conn, $dno);

    $route = htmlspecialchars($_POST['selectedRoute']);
    $route = mysqli_real_escape_string($conn, $route);

    $driver = htmlspecialchars($_POST['driver']);
    $driver = mysqli_real_escape_string($conn, $driver);


    $query = "SELECT * FROM delivery WHERE delivery_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $dno);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $delivery = $result->fetch_assoc();

        //check the route and then add

        date_default_timezone_set('Asia/Colombo');
        $date = date('Y-n-j');
        $time = date('H:i:s');

        if($delivery['route'] == $route){

            $assigned = "assigned";
            $q = "UPDATE delivery SET ack_status = ?, driverId = ? , assigned_time = ? , assigned_date = ? WHERE delivery_no = ?";
            $s = $conn->prepare($q);
            $s->bind_param('sisss', $assigned,$driver,$time,$date,$dno);
            if($s->execute()){

                $q_driver = "SELECT * FROM driver WHERE id = ?";
                $s_driver = $conn->prepare($q_driver);
                $s_driver->bind_param('i', $driver);
                if($s_driver->execute()){
                    $result_driver = $s_driver->get_result();
                    if ($result_driver->num_rows == 1) {
                        $vehicle_data = $result_driver->fetch_assoc();
                        $vehicleNumber = $vehicle_data['vehicle'];
                        $driverName = $vehicle_data['name'];
                        $driverPhoneNumber = $vehicle_data['phone'];

                        $actoin_description = "Assigned to a vehicle";
                        $action_remark = $vehicleNumber ."/". $driverName . "/" . $driverPhoneNumber;

                        $q_action = "INSERT INTO delivery_action(delivery_number,action_date,action_time,action,user,remark) VALUE (?,?,?,?,?,?)";
                        $s_action = $conn->prepare($q_action);
                        $s_action->bind_param('ssssis', $dno,$date,$time,$actoin_description,$userDbID,$action_remark);
                        $s_action->execute();
                    }
                }

                $response = array(
                    'requestStatus' => 200,
                    'message' => 'Success!'
                );
                echo json_encode($response);
                
            }else{
                $response = array(
                    'requestStatus' => 500,
                    'message' => 'Failed to assign the deliver!'
                );
                echo json_encode($response);
            }

        }else{

            $response = array(
                'requestStatus' => 500,
                'message' => 'Route numbers are not matched!'
            );
            echo json_encode($response);

        }


    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Delivery not found!'
        );
        echo json_encode($response);
    }

}

?>