<?php
include("../userAuth.php");


if(isset($_POST['clientID'])){
    $code = htmlspecialchars($_POST['clientID']);
    $code = mysqli_real_escape_string($conn, $code);

    $query = "SELECT * FROM client WHERE code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $client = $result->fetch_assoc();
        $id = $client['id'];
        $code = $client['code'];
        $name = $client['name'];
        $city = $client['city'];
        $address = $client['address'];
        $route = $client['route'];
        $status = $client['status'];
        $added_by = $client['added_by'];
        $added_date_time = $client['added_date_time'];

        $q_route = "SELECT * FROM route WHERE id = ?";
        $s_route = $conn->prepare($q_route);
        $s_route->bind_param('i', $route);
        $s_route->execute();
        $r_route = $s_route->get_result();
        $m_route = $r_route->fetch_assoc();

        $response = array(
            'requestStatus' => 200,
            'message' => 'Success',
            'id' => $id,
            'code' => $code,
            'name' => $name,
            'city' => $city,
            'address' => $address,
            'route' => $route,
            'status' => $status,
            'added_by' => $added_by,
            'added_date_time' => $added_date_time,
            'mainRoute' => $m_route['m_id']
        );
    
        echo json_encode($response);

    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Client Not Found!'
        );
        echo json_encode($response);
    }

}

?>