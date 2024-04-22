<?php
include("../userAuth.php");

if(isset($_POST['deliveryNumber'])){

    $deliveryNumber = htmlspecialchars($_POST['deliveryNumber']);
    $deliveryNumber = mysqli_real_escape_string($conn, $deliveryNumber);

    $query = "SELECT * FROM delivery WHERE delivery_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $deliveryNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {

        $delivery = $result->fetch_assoc();

        $stpCode = $delivery['stp_code'];
        $stpName = $delivery['stp_name'];
        $status = $delivery['ack_status'];
        $scanStatus = $delivery['updated_status'];
        $remark = $delivery['remark'];

        $actions = array();

        $q = "SELECT * FROM delivery_action WHERE delivery_number = ?";
        $s = $conn->prepare($q);
        $s->bind_param('s', $deliveryNumber);
        $s->execute();
        $r = $s->get_result();
        if ($r->num_rows != 0) {
            while($action = $r->fetch_assoc()){

                $actionUserId = $action['user'];

                if($action['user'] == 0){
                    $action['user'] = "DMS";
                }else{
                    $q_user = "SELECT * FROM user WHERE id = ?";
                    $s_user = $conn->prepare($q_user);
                    $s_user->bind_param('i', $actionUserId);
                    $s_user->execute();
                    $r_user = $s_user->get_result();
                    if ($r_user->num_rows == 1) {
                        $actionUser = $r_user->fetch_assoc();
                        $actionUsername = $actionUser['username'];
                        $action['user'] = $actionUsername;
    
                    }else{
                        $action['user'] = "User not found";
                    }
                }

                $actions[] = $action;
            }
        }


        $actionString = json_encode($actions);


        if(count($actions) == 0){

            $response = array(
                'requestStatus' => 200,
                'message' => 'Success!',
                'deliveryNumber' => $deliveryNumber,
                'stpCode' => $stpCode,
                'stpName' => $stpName,
                'status' => $status,
                'scanStatus' => $scanStatus,
                'remark' => $remark,
                'actionCount' => count($actions),
                'actions' => $actionString
            );
            echo json_encode($response);

        }else{

            $response = array(
                'requestStatus' => 200,
                'message' => 'Success!',
                'deliveryNumber' => $deliveryNumber,
                'stpCode' => $stpCode,
                'stpName' => $stpName,
                'status' => $status,
                'scanStatus' => $scanStatus,
                'remark' => $remark,
                'actionCount' => count($actions),
                'actions' => $actionString
            );
            echo json_encode($response);

        }


    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Unkown delivery number!'
        );
        echo json_encode($response);
    }

}

?>