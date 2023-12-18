<?php
include("../userAuth.php");

if(isset($_POST['deliveryNumber'])){

    $dn = htmlspecialchars($_POST['deliveryNumber']);
    $dn = mysqli_real_escape_string($conn, $dn);

    $query = "SELECT * FROM delivery WHERE delivery_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $dn);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        
        $delivery = $result->fetch_assoc();
        $status = $delivery['ack_status'];
        $stpCode = $delivery['stp_code'];
        $customerName = $delivery['stp_name'];
        $remark = $delivery['remark'];

        if($status == "pending"){

            $response = array(
                'requestStatus' => 200,
                'message' => 'Success!',
                'dn' => $dn,
                'stpCode' => $stpCode,
                'stpName' => $customerName,
                'remark' => $remark
            );
            echo json_encode($response);

        }else{

            $response = array(
                'requestStatus' => 500,
                'message' => 'Delivery is Already assigned!'
            );
            echo json_encode($response);

        }


    }else{

        $response = array(
            'requestStatus' => 500,
            'message' => 'Delivery Not Found!'
        );
        echo json_encode($response);

    }
}

?>