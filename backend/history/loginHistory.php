<?php
include("../userAuth.php");

if (isset($_POST['username']) && isset($_POST['limit']) && isset($_POST['lastRecordId'])) {
    $username = $_POST['username'];
    $recordsPerScroll = $_POST['limit'];
    $lastRecordId = $_POST['lastRecordId'];

    $query = "SELECT * FROM login_history WHERE username = ? AND id > ? ORDER BY id ASC LIMIT ?";
    $s = $conn->prepare($query);
    $s->bind_param('sii', $username, $lastRecordId, $recordsPerScroll);
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