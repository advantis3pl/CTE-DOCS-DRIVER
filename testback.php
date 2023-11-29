<?php
/*
include("config/conn.php");

if(isset($_POST['dataList'])) {
    $data = json_decode($_POST['dataList'], true);
    foreach ($data as $d) {
        $code = $d[0] ?? "";
        $name = $d[1] ?? "";
        $city = $d[2] ?? "";
        $route = $d[3] ?? "";

        $address = "n/a";
        $status = "active";
        $added_by = 12;
        $date = "2023-11-24 15:36:00";

        $stmt = $conn->prepare("INSERT INTO client (code, name, city, address, route, status, added_by,added_date_time) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
        $stmt->bind_param("ssssssis", $code, $name, $city,$address,$route,$status, $added_by,$date);

        if ($stmt->execute()) {
            echo "Record inserted successfully";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
    
}else{
    echo "Failed";
}
*/
?>
