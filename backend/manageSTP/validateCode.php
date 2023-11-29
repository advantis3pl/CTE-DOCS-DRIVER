<?php
include("../userAuth.php");

if(isset($_POST['code'])){

    $code = htmlspecialchars($_POST['code']);
    $code = mysqli_real_escape_string($conn, $code);

    $query = "SELECT * FROM client WHERE code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $response = array(
            'requestStatus' => 200,
            'message' => 'Success!'
        );
        echo json_encode($response);
    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Client code is already taken!'
        );
        echo json_encode($response);
    }

}

?>