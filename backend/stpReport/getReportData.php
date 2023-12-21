<?php
include("../userAuth.php");

if(isset($_POST['reportType']) && isset($_POST['from']) && isset($_POST['to'])){
    $reportType = htmlspecialchars($_POST['reportType']);
    $reportType = mysqli_real_escape_string($conn, $reportType);

    $from = htmlspecialchars($_POST['from']);
    $from = mysqli_real_escape_string($conn, $from);

    $to = htmlspecialchars($_POST['to']);
    $to = mysqli_real_escape_string($conn, $to);

    $from = new DateTime($from);
    $to = new DateTime($to);

    $from = $from->format('Y-n-j');
    $to = $to->format('Y-n-j');

    $recordLimiter = 30000;


    if($reportType == "distribution_summary_report"){

    }else if($reportType == "sdr_report"){

    }else if($reportType == "nddn_report"){

    }else if($reportType == "pending_collection_report"){

        $records = array();
        $counter = 0;

        $query = "SELECT * FROM delivery WHERE invoice_date BETWEEN ? AND ? AND ack_status = 'pending' LIMIT ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $from, $to, $recordLimiter);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {

                $counter++;

                if($counter == 1){
                    $records[] = array("Pending Delivery Report");
                    $records[] = array(
                        "Invoice Date","Delivery Note #","STP","Customer Name","Route Number","Route","Remark"
                    );
                }

                $invoiceDate = $row['invoice_date'];
                $deliveryNumber = $row['delivery_no'];
                $stpCode = $row['stp_code'];
                $stpName = $row['stp_name'];
                $routeNumber = $row['route'];
                $remark = $row['remark'];

                $q = "SELECT * FROM route WHERE id = ?";
                $s = $conn->prepare($q);
                $s->bind_param('i', $routeNumber);
                if($s->execute()){
                    $r = $s->get_result();
                    $ru = $r->fetch_assoc();
                    $route = $ru['name'];

                    $newObject = array(
                        $invoiceDate,
                        $deliveryNumber,
                        $stpCode,
                        $stpName,
                        $routeNumber,
                        $route,
                        $remark
                    );
                    
                    $records[] = $newObject;
                }
            }

            $recordString = json_encode($records);

            $response = array(
                'requestStatus' => 200,
                'message' => 'Success!',
                'records' => $recordString
            );
            echo json_encode($response);

        } else {
            // Handle execution error
            $response = array(
                'requestStatus' => 500,
                'message' => 'Failed to generate report!',
                'records' => 'none'
            );
            echo json_encode($response);
        }


    }else if($reportType == "customer_collection_report"){

        $records = array();
        $counter = 0;

        $query = "SELECT * FROM delivery WHERE invoice_date BETWEEN ? AND ? AND ack_status = 'CC' LIMIT ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $from, $to, $recordLimiter);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {

                $counter++;

                $invoiceDate = $row['invoice_date'];
                $processesDate = $row['assigned_date'];
                $deliveryNumber = $row['delivery_no'];
                $stp = $row['stp_code'];
                $stpName = $row['stp_name'];
                $remark = $row['remark'];
                $status = $row['ack_status'];
                $scannedStatus = $row['updated_status'];

                if($counter == 1){
                    $records[] = array("Customer Collection Report");
                    $records[] = array(
                        "Invoice Date","Assigned Date","Delivery No","STP","Customer Name","Remark","Status","Scan Status"
                    );
                }

                $records[] = array(
                    $invoiceDate,$processesDate,$deliveryNumber,$stp,$stpName,$remark,$status,$scannedStatus
                );

            }

            //success
            $recordString = json_encode($records);
            $response = array(
                'requestStatus' => 200,
                'message' => 'Success!',
                'records' => $recordString
            );
            echo json_encode($response);

        }else{
            $response = array(
                'requestStatus' => 500,
                'message' => 'Failed to generate report!',
                'records' => 'none'
            );
            echo json_encode($response);
        }

    }else if($reportType == "special_collection_report"){


        $records = array();
        $counter = 0;

        $query = "SELECT * FROM delivery WHERE invoice_date BETWEEN ? AND ? AND ack_status = 'SD' LIMIT ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $from, $to, $recordLimiter);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {

                $counter++;

                $invoiceDate = $row['invoice_date'];
                $processesDate = $row['assigned_date'];
                $deliveryNumber = $row['delivery_no'];
                $stp = $row['stp_code'];
                $stpName = $row['stp_name'];
                $remark = $row['remark'];
                $status = $row['ack_status'];
                $scannedStatus = $row['updated_status'];

                if($counter == 1){
                    $records[] = array("Special Delivery Report");
                    $records[] = array(
                        "Invoice Date","Assigned Date","Delivery No","STP","Customer Name","Remark","Status","Scan Status"
                    );
                }

                $records[] = array(
                    $invoiceDate,$processesDate,$deliveryNumber,$stp,$stpName,$remark,$status,$scannedStatus
                );

            }

            //success
            $recordString = json_encode($records);
            $response = array(
                'requestStatus' => 200,
                'message' => 'Success!',
                'records' => $recordString
            );
            echo json_encode($response);

        }else{
            $response = array(
                'requestStatus' => 500,
                'message' => 'Failed to generate report!',
                'records' => 'none'
            );
            echo json_encode($response);
        }

        
    }else if($reportType == "reconcile_report"){


        $records = array();
        $counter = 0;

        $query = "SELECT * FROM delivery WHERE invoice_date BETWEEN ? AND ? LIMIT ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $from, $to, $recordLimiter);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {

                $counter++;

                if($counter == 1){
                    $records[] = array("Reconcile Report");
                    $records[] = array(
                        "Invoice Date",
                        "Delivery Note#",
                        "STP",
                        "Customer Name",
                        "Created By",
                        "Route Number",
                        "Route",
                        "Status",
                        "Scan Status",
                        "Driver Name",
                        "Vehicle No",
                        "Remark"
                    );
                }

                $invoiceDate = $row['invoice_date'];
                $deliveryNumber = $row['delivery_no'];
                $stp = $row['stp_code'];
                $stpName = $row['stp_name'];
                $remark = $row['remark'];
                $status = $row['ack_status'];
                $scannedStatus = $row['updated_status'];
                $createdBy = $row['created_by'];
                $routeNumber = $row['route'];
                $vehicleId = $row['driverId'];
                
                $vehicleNumber = "";
                $driverName = "";
                $route = "";

                $q = "SELECT * FROM route WHERE id = ?";
                $s = $conn->prepare($q);
                $s->bind_param('i', $routeNumber);
                if($s->execute()){
                    $r = $s->get_result();
                    $ru = $r->fetch_assoc();
                    $route = $ru['name'];

                    if($vehicleId == 0){

                        $records[] = array(
                            $invoiceDate,
                            $deliveryNumber,
                            $stp,$stpName,$createdBy,$routeNumber,$route,$status,$scannedStatus,
                            $driverName,$vehicleNumber,$remark
                        );

                    }else{

                        $q_d = "SELECT * FROM driver WHERE id = ?";
                        $s_d = $conn->prepare($q_d);
                        $s_d->bind_param('i', $vehicleId);
                        if($s_d->execute()){
                            $r_d = $s_d->get_result();
                            $ru_d = $r_d->fetch_assoc();
                            $driverName = $ru_d['name'];
                            $vehicleNumber = $ru_d['vehicle'];
                            $records[] = array(
                                $invoiceDate,
                                $deliveryNumber,
                                $stp,$stpName,$createdBy,$routeNumber,$route,$status,$scannedStatus,
                                $driverName,$vehicleNumber,$remark
                            );
                        }

                    }


                }

            }

            //success
            $recordString = json_encode($records);
            $response = array(
                'requestStatus' => 200,
                'message' => 'Success!',
                'records' => $recordString
            );
            echo json_encode($response);

        }else{
            $response = array(
                'requestStatus' => 500,
                'message' => 'Failed to generate report!',
                'records' => 'none'
            );
            echo json_encode($response);
        }


    }


}





?>