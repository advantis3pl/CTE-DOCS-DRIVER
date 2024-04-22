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
    if($reportType == "distribution_summary"){

        $records = array();
        $counter = 0;

        $query = "SELECT * FROM driver WHERE isPrinted = 'true' AND printedDate BETWEEN ? AND ? LIMIT ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $from, $to, $recordLimiter);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $counter++;
                if($counter == 1){
                    $records[] = array("Distribution Summary");
                    $records[] = array(
                        "Delivery Date","Route","Boxes","Parcels","Log Sheet","Deliveryman","Vehicle","NIC"
                    );
                }
                $routeNumber = $row['route'];
                $q = "SELECT * FROM route WHERE id = ?";
                $s = $conn->prepare($q);
                $s->bind_param('i', $routeNumber);
                if($s->execute()){
                    $r = $s->get_result();
                    $ru = $r->fetch_assoc();
                    $route = $ru['name'];
                    $records[] = array(
                        $row['printedDate'],
                        $route,
                        $row['no_box'],
                        $row['no_parcel'],
                        $row['log_no'],
                        $row['name'],
                        $row['vehicle'],
                        $row['nic']
                    );

                }else{
                    //route not found
                    $records[] = array(
                        $row['printedDate'],
                        $routeNumber,
                        $row['no_box'],
                        $row['no_parcel'],
                        $row['log_no'],
                        $row['name'],
                        $row['vehicle'],
                        $row['nic']
                    );
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

    }else if($reportType == "nddn_report" || $reportType == "sdr_report"){

        $title = "";
        $reportType_new = "";
        $dbType = "";

        if($reportType == "nddn_report"){
            $title = "Not Delivered DN";
            $reportType_new = "Not Delivered DN";
            $dbType = "ND";
        }else{
            $title = "Same Day Return";
            $reportType_new = "SDR";
            $dbType = "SDR";
        }

        $records = array();
        $counter = 0;

        $query = "SELECT * FROM return_record WHERE return_date BETWEEN ? AND ? AND type = ? LIMIT ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $from, $to, $dbType, $recordLimiter);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {

                $counter++;

                if($counter == 1){
                    $records[] = array($title);
                    $records[] = array(
                        "Invoice Date","Delivery Date","Delivery Number","STP Code","STP Name","Date","Time","Remark","Type", "Route", "Vehicle Number", "Driver Name", "Driver NIC"
                    );
                }

                $routeNumber = $row['route'];
                $vehicleId = $row['vehicle'];


                $q_get_del = "SELECT * FROM delivery WHERE delivery_no = ?";
                $s_get_del = $conn->prepare($q_get_del);
                $s_get_del->bind_param('s', $row['delivery_no']);
                if($s_get_del->execute()){
                    $r_get_del = $s_get_del->get_result();
                    $ru_get_del = $r_get_del->fetch_assoc();
                    $invoiceDate = $ru_get_del['invoice_date'];


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
                                $row['assign_date'],
                                $row['delivery_no'],
                                $row['stp_code'],
                                $row['stp_name'],
                                $row['return_date'],
                                $row['return_time'],
                                $row['remark'],
                                $reportType_new,
                                $route,
                                "","",""
                            );

                        }else{

                            $q_d = "SELECT * FROM driver WHERE id = ?";
                            $s_d = $conn->prepare($q_d);
                            $s_d->bind_param('i', $vehicleId);
                            if($s_d->execute()){
                                $r_d = $s_d->get_result();
                                $ru_d = $r_d->fetch_assoc();
                                $dName = $ru_d['name'];
                                $vehicleNumber = $ru_d['vehicle'];
                                
                                $records[] = array(
                                    $invoiceDate,
                                    $row['assign_date'],
                                    $row['delivery_no'],
                                    $row['stp_code'],
                                    $row['stp_name'],
                                    $row['return_date'],
                                    $row['return_time'],
                                    $row['remark'],
                                    $reportType_new,
                                    $route,
                                    $vehicleNumber,
                                    $dName,
                                    $ru_d['nic']
                                );

                            }
                        }
                    }else{
                        $response = array(
                            'requestStatus' => 500,
                            'message' => 'Failed to generate report!',
                            'records' => 'none'
                        );
                        echo json_encode($response);
                    }


                }else{
                    $response = array(
                        'requestStatus' => 500,
                        'message' => 'Failed to generate report!',
                        'records' => 'none'
                    );
                    echo json_encode($response);
                }
            }

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
                        "Assigned Date",
                        "Assigned Time",
                        "Scanned Date",
                        "Scanned Time",
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
                $assignedDate = $row['assigned_date'];
                $assignedTime = $row['assigned_time'];
                $scannedDate = $row['scanned_date'];
                $scannedTime = $row['scanned_time'];
                
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
                            $driverName,$vehicleNumber,$assignedDate,$assignedTime,$scannedDate,$scannedTime,$remark
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
                                $driverName,$vehicleNumber,$assignedDate,$assignedTime,$scannedDate,$scannedTime,$remark
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