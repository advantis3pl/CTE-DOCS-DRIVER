<?php
include("../userAuth.php");

if(isset($_POST['deliveryId']) &&
isset($_POST['deliveryNumber']) &&
isset($_POST['remark']) &&
isset($_POST['type']) &&
isset($_POST['route']) &&
isset($_POST['vehicle'])){

    $deliveryId = htmlspecialchars($_POST['deliveryId']);
    $deliveryId = mysqli_real_escape_string($conn, $deliveryId);

    $deliveryNumber = htmlspecialchars($_POST['deliveryNumber']);
    $deliveryNumber = mysqli_real_escape_string($conn, $deliveryNumber);

    $remark = htmlspecialchars($_POST['remark']);
    $remark = mysqli_real_escape_string($conn, $remark);

    $type = htmlspecialchars($_POST['type']);
    $type = mysqli_real_escape_string($conn, $type);

    $route = htmlspecialchars($_POST['route']);
    $route = mysqli_real_escape_string($conn, $route);

    $vehicle = htmlspecialchars($_POST['vehicle']);
    $vehicle = mysqli_real_escape_string($conn, $vehicle);

    date_default_timezone_set('Asia/Colombo');
    $date = date('Y-n-j');
    $time = date('H:i:s');


    //userid = $userDbID
    $query = "SELECT * FROM delivery WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $deliveryId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {

        $delivery = $result->fetch_assoc();
        $assignedDate = $delivery['assigned_date'];
        $assignedTime = $delivery['assigned_time'];

        $stpCode = $delivery['stp_code'];
        $stpName = $delivery['stp_code'];

        $q = "INSERT INTO return_record(delivery_id,delivery_no,stp_code,stp_name, return_time,return_date,assign_time,assign_date,user,remark,type,route,vehicle) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $s = $conn->prepare($q);
        $s->bind_param('isssssssissii', $deliveryId,$deliveryNumber,$stpCode,$stpName,$time,$date,$assignedTime,$assignedDate,$userDbID,$remark,$type,$route,$vehicle);
        if($s->execute()){

            $pending = "pending";
            $empty = "";

            $q_ud = "UPDATE delivery SET ack_status = ?,return_status = ?,assigned_time = ?, assigned_date = ?, driverId = ?  WHERE id = ?";
            $s_ud = $conn->prepare($q_ud);
            $s_ud->bind_param('sssssi', $pending,$type,$empty,$empty,$empty,$deliveryId);
            if($s_ud->execute()){

                $response = array(
                    'requestStatus' => 200,
                    'message' => 'Success!'
                );
                echo json_encode($response);

                $newType = "";
                if($type == "ND"){
                    $newType = "Not Delivered DN";
                }else{
                    $newType = "Same Day Return";
                }

                $actoin_description = "Status updated as " . $newType;
                $action_remark = $remark;
                $q_action = "INSERT INTO delivery_action(delivery_number,action_date,action_time,action,user,remark) VALUE (?,?,?,?,?,?)";
                $s_action = $conn->prepare($q_action);
                $s_action->bind_param('ssssis', $deliveryNumber,$date,$time,$actoin_description,$userDbID,$action_remark);
                $s_action->execute();


            }else{
                $response = array(
                    'requestStatus' => 400,
                    'message' => 'Return data saved. But failed to update delivery status as PENDING!'
                );
                echo json_encode($response);
            }



        }else{
            $response = array(
                'requestStatus' => 500,
                'message' => 'Failed to Update Assigned delivery!'
            );
            echo json_encode($response);
        }

    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Delivery Id not found!'
        );
        echo json_encode($response);
    }


}

?>