<?php
include("../userAuth.php");

if(isset($_POST['report'])){
    $report = json_decode($_POST['report'], true);
    $foundDeliveryNumbers = array();
    foreach ($report as $data) {
        $deliveryNo = htmlspecialchars($data);
        $deliveryNo = mysqli_real_escape_string($conn, $deliveryNo);

        $query = "SELECT * FROM delivery WHERE delivery_no = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $deliveryNo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows != 0) {
            $foundDeliveryNumbers[] = $deliveryNo;
        }
    }

    if(count($foundDeliveryNumbers) != 0){
        $response = array(
            'requestStatus' => 500,
            'message' => 'These delivery numbers are already uploaded: ' . implode(', ', $foundDeliveryNumbers)
        );
        echo json_encode($response);
    }else{
        $response = array(
            'requestStatus' => 200,
            'message' => 'Success!'
        );
        echo json_encode($response);
    }

}

?>