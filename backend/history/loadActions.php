<?php
include("../userAuth.php");

if (isset($_POST['uid']) && isset($_POST['limit']) && isset($_POST['lastRecordId'])) {
    $history_userId = $_POST['uid'];
    $recordsPerScroll = $_POST['limit'];
    $lastRecordId = $_POST['lastRecordId'];

    $query = "SELECT * FROM delivery_action WHERE user = ? AND id > ? ORDER BY id ASC LIMIT ?";
    $s = $conn->prepare($query);
    $s->bind_param('iii', $history_userId, $lastRecordId, $recordsPerScroll);
    $s->execute();
    $result = $s->get_result();

    $response = [];

    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }

    // Debugging: Output the response to see what data is being sent
    echo json_encode($response);

    $conn->close();
}
?>
