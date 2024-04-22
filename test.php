<?php

include("config/conn.php");

$records = array();
$counter = 0;

$recordLimiter = 30000;
$from = "2023/11/11";
$to = "2024/01/11";

$query = "SELECT * FROM driver WHERE isPrinted = 'true' AND printedDate BETWEEN ? AND ? LIMIT ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssi', $from, $to, $recordLimiter);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo $row['id']. "</br>";
    }
}else{
    $response = array(
        'requestStatus' => 500,
        'message' => 'Failed to generate report!',
        'records' => 'none'
    );
    echo json_encode($response);
}

?>