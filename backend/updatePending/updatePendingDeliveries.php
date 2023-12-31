<?php
include("../userAuth.php");

if(isset($_POST['type']) && isset($_POST['deliveries'])){


    $type = htmlspecialchars($_POST['type']);
    $type = mysqli_real_escape_string($conn, $type);

    $deliveries = json_decode($_POST['deliveries'], true);

    date_default_timezone_set('Asia/Colombo');
    $currentDate = date('Y-n-j');
    $currentTime = date('H:i:s');

    $fails = array();
    $counter = 0;

    foreach ($deliveries as $data) {

        $dn = htmlspecialchars($data[0]);
        $dn = mysqli_real_escape_string($conn, $dn);

        $stpCode = htmlspecialchars($data[1]);
        $stpCode = mysqli_real_escape_string($conn, $stpCode);

        $stpName = htmlspecialchars($data[2]);
        $stpName = mysqli_real_escape_string($conn, $stpName);

        $remark = htmlspecialchars($data[3]);
        $remark = mysqli_real_escape_string($conn, $remark);

        $query = "UPDATE delivery SET remark = ? , ack_status = ?, assigned_time = ?, assigned_date = ? WHERE delivery_no = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssss', $remark,$type,$currentTime,$currentDate,$dn);
        if($stmt->execute()){
            $counter++;

            $actoin_description = "Delivery status updated to " . $type;
            $action_remark = $remark;
            $q_action = "INSERT INTO delivery_action(delivery_number,action_date,action_time,action,user,remark) VALUE (?,?,?,?,?,?)";
            $s_action = $conn->prepare($q_action);
            $s_action->bind_param('ssssis', $dn,$currentDate,$currentTime,$actoin_description,$userDbID,$action_remark);
            $s_action->execute();

        }else{
            $fails[] = $dn;
        }

    }

    $failsString = implode(', ', $fails);

    if(count($deliveries) == $counter){
        $response = array(
            'requestStatus' => 200,
            'message' => 'Success!'
        );
        echo json_encode($response);
    }else if($counter == 0){
        $response = array(
            'requestStatus' => 500,
            'message' => 'Failed to update deliveries'
        );
        echo json_encode($response);
    }else if($counter != 0){
        $response = array(
            'requestStatus' => 400,
            'message' => 'Completed with fails. Failed DN - ' . $failsString . $counter . "/" . count($deliveries)
        );
        echo json_encode($response);
    }
}