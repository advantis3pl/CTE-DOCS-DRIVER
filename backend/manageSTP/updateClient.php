<?php
include("../userAuth.php");

if(isset($_POST['clientDBId']) &&
isset($_POST['clientID']) &&
isset($_POST['name']) &&
isset($_POST['address']) &&
isset($_POST['city']) &&
isset($_POST['route']) &&
isset($_POST['status']) &&
isset($_POST['mainRoute'])){

    $clientDBId = htmlspecialchars($_POST['clientDBId']);
    $clientDBId = mysqli_real_escape_string($conn, $clientDBId);

    $code = htmlspecialchars($_POST['clientID']);
    $code = mysqli_real_escape_string($conn, $code);

    $name = htmlspecialchars($_POST['name']);
    $name = mysqli_real_escape_string($conn, $name);

    $address = htmlspecialchars($_POST['address']);
    $address = mysqli_real_escape_string($conn, $address);

    $city = htmlspecialchars($_POST['city']);
    $city = mysqli_real_escape_string($conn, $city);

    $route = htmlspecialchars($_POST['route']);
    $route = mysqli_real_escape_string($conn, $route);

    $status = htmlspecialchars($_POST['status']);
    $status = mysqli_real_escape_string($conn, $status);

    $oldMainRoute = htmlspecialchars($_POST['mainRoute']);
    $oldMainRoute = mysqli_real_escape_string($conn, $oldMainRoute);

    $query = "UPDATE client SET code = ?, name = ?, city = ?, address = ?, route = ?,status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssssi', $code,$name,$city,$address,$route,$status,$clientDBId);
    if($stmt->execute()){

        //get the newMainRoute where id = $route
        $q_route = "SELECT * FROM route WHERE id = ?";
        $s_route = $conn->prepare($q_route);
        $s_route->bind_param('i', $route);
        $s_route->execute();
        $r_route = $s_route->get_result();
        $m_route = $r_route->fetch_assoc();
        $newMainRoute = $m_route['m_id'];


        //if newMainroute != oldMainRoute ->
        if($newMainRoute != $oldMainRoute){
            //update the route of pending deliveries where client code  = $code
            $query_del = "SELECT * FROM delivery WHERE stp_code = ? AND ack_status = 'pending'";
            $stmt_del = $conn->prepare($query_del);
            $stmt_del->bind_param('s', $code);
            $stmt_del->execute();
            $result_del = $stmt_del->get_result();
            if ($result_del->num_rows > 0) {

                while($delivery = $result_del->fetch_assoc()){

                    $query_u_del = "UPDATE delivery SET route = ? WHERE id = ?";
                    $stmt_u_del = $conn->prepare($query_u_del);
                    $stmt_u_del->bind_param('ii', $newMainRoute,$delivery['id']);
                    $stmt_u_del->execute();
                }
                $response = array(
                    'requestStatus' => 200,
                    'message' => 'Success! - deliveries updated'
                );
                echo json_encode($response);
                
            }else{
                $response = array(
                    'requestStatus' => 200,
                    'message' => 'Success - No Deliveries found!'
                );
                echo json_encode($response);
            }

        }else{
            $response = array(
                'requestStatus' => 200,
                'message' => 'Success - Main routes are equal. - No RAS updates!'
            );
            echo json_encode($response);
        }

    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Something went wrong!'
        );
        echo json_encode($response);
    }
}

?>