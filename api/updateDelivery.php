<?php
include("../config/conn.php");

// Function to handle the API request
function updateDeliveryStatus() {
    global $conn;

    $pass = "Ct3_2024v1#";
    $user = "CTE_API_v1";

    // Check if headers are set
    if (isset($_SERVER['HTTP_USERNAME']) && isset($_SERVER['HTTP_PASSWORD'])) {
        $username = $_SERVER['HTTP_USERNAME'];
        $password = $_SERVER['HTTP_PASSWORD'];

        // Validate username and password (You should use a secure authentication mechanism)
        if ($username === $user && $password === $pass) {
            // Check if the request method is POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Check if the request body is set
                $inputJSON = file_get_contents('php://input');
                $inputData = json_decode($inputJSON, true);

                // Get delivery number from API user
                if (isset($inputData['delivery_no'])) {
                    $deliveryNo = $inputData['delivery_no'];

                    $pending = "pending";
                    
                    $checkSql = "SELECT COUNT(*) FROM delivery WHERE delivery_no = ? AND ack_status != ?";
                    $checkStmt = $conn->prepare($checkSql);
                    $checkStmt->bind_param("ss", $deliveryNo,$pending);

                    if($checkStmt->execute()){

                        $checkStmt->bind_result($deliveryCount);
                        $checkStmt->fetch();
                        $checkStmt->close();

                        if ($deliveryCount === 1) {
                            // Delivery exists, proceed with the update
                            // SQL statement
                            $sql = "UPDATE delivery SET updated_status=?, scanned_time=?, scanned_date=? WHERE delivery_no=?";
                            
                            // Prepare and execute the statement
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("ssss", $status, $time, $date, $deliveryNo);

                            // Set parameters
                            $status = "scanned";

                            date_default_timezone_set('Asia/Colombo');
                            $date = date('Y-n-j');
                            $time = date('H:i:s');

                            // Execute the statement
                            $stmt->execute();

                            // Check for success and send appropriate response
                            if ($stmt->affected_rows > 0) {
                                sendResponse(true, 200, "Delivery updated successfully");
                            } else {
                                sendResponse(false, 500, "Internal server error");
                            }

                            // Close the statement
                            $stmt->close();
                        } else {
                            // Delivery does not exist, return 500 server error
                            sendResponse(false, 400, "Delivery not found");
                        }

                    }else{
                        sendResponse(false, 500, "Internal server error");
                    }
                    

                } else {
                    sendResponse(false, 400, "Delivery number is missing");
                }
                
            } else {
                sendResponse(false, 400, "Invalid request method");
            }
        } else {
            sendResponse(false, 401, "Unauthorized");
        }
    } else {
        sendResponse(false, 401, "Unauthorized");
    }
}

// Function to send the API response
function sendResponse($success, $statusCode, $message) {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode(['code' => $statusCode, 'success' => $success, 'message' => $message]);
    exit;
}

// Call the update function
updateDeliveryStatus();
?>
