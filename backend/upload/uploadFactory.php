<?php
include("../userAuth.php");

if(isset($_POST['type']) &&
isset($_POST['report'])){

    $type = htmlspecialchars($_POST['type']);
    $type = mysqli_real_escape_string($conn, $type);

    $report = json_decode($_POST['report'], true);

    date_default_timezone_set('Asia/Colombo');
    $currentDate = date('Y-n-j');
    $currentTime = date('H:i:s');
    
    $reportId = $reportId = substr(md5(uniqid(rand(), true)), 0, 20);


    $clientsThatNotAvailable = array();
    $routes = array();


    foreach($report as $data){

        $delivery = htmlspecialchars($data[0]);
        $delivery = mysqli_real_escape_string($conn, $delivery);
        $stpCode = htmlspecialchars($data[1]);
        $stpCode = mysqli_real_escape_string($conn, $stpCode);

        $query = "SELECT * FROM client WHERE code = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $stpCode);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            $clientsThatNotAvailable[] = $stpCode;
        }else{
            $cl = $result->fetch_assoc();
            $routes[] = $cl['route'];
        }
    }


    if(count($clientsThatNotAvailable) == 0){

        $query = "INSERT INTO delivery_report(report_id, uploaded_by, upload_date,upload_time, report_type) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sisss', $reportId,$userDbID,$currentDate,$currentTime,$type);
        if($stmt->execute()){

            $counter = 0;
            $arrayCounter = 0; 

            foreach ($report as $data) {

                $currentRoute = $routes[$arrayCounter];
                $arrayCounter++;

                $delivery = htmlspecialchars($data[0]);
                $delivery = mysqli_real_escape_string($conn, $delivery);

                $stpCode = htmlspecialchars($data[1]);
                $stpCode = mysqli_real_escape_string($conn, $stpCode);
        
                $stpName = htmlspecialchars($data[2]);
                $stpName = mysqli_real_escape_string($conn, $stpName);
        
                $invoiceDate = htmlspecialchars($data[3]);
                $invoiceDate = mysqli_real_escape_string($conn, $invoiceDate);
        
                $stpLocation = htmlspecialchars($data[4]);
                $stpLocation = mysqli_real_escape_string($conn, $stpLocation);
        
                $createdBy = htmlspecialchars($data[5]);
                $createdBy = mysqli_real_escape_string($conn, $createdBy);
                
                $sendingDate = htmlspecialchars($data[6]);
                $sendingDate = mysqli_real_escape_string($conn, $sendingDate);
                
                $productionTransfer = htmlspecialchars($data[7]);
                $productionTransfer = mysqli_real_escape_string($conn, $productionTransfer);
                
                $remark = htmlspecialchars($data[8]);
                $remark = mysqli_real_escape_string($conn, $remark);

                $pendingTime = $currentTime;
                $pendingDate = $currentDate;
                $ackStatus = "pending";
                $empty = "";

                $q = "INSERT INTO delivery(report_id, delivery_no, stp_code,stp_name, invoice_date,
                stp_location,created_by,sending_date,production_transfer,remark,ack_status,updated_status,
                return_status,pending_time,pending_date,assigned_time,assigned_date,scanned_time,scanned_date,route) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $s = $conn->prepare($q);
                $s->bind_param('sssssssssssssssssssi', $reportId,$delivery,$stpCode,$stpName,$invoiceDate,$stpLocation,$createdBy,$sendingDate,$productionTransfer,$remark,$ackStatus,$empty,$empty,$pendingTime,$pendingDate,$empty,$empty,$empty,$empty,$currentRoute);
                if($s->execute()){
                    $counter++;
                }

            }

            if(count($report) == $counter){
                $response = array(
                    'requestStatus' => 200,
                    'message' => 'Report uploaded successfully!'
                );
                echo json_encode($response);
            }else{
                $response = array(
                    'requestStatus' => 500,
                    'message' => 'Something went wrong! Report not uploaded successfully!'
                );
                echo json_encode($response);
            }

        }else{
            $response = array(
                'requestStatus' => 500,
                'message' => 'Failed to Create the report!'
            );
            echo json_encode($response);
        }

    }else{
        $response = array(
            'requestStatus' => 500,
            'message' => 'Unkown ship-to-party codes : ' . implode(', ', $clientsThatNotAvailable)
        );
        echo json_encode($response);
    }

}

?>