<?php
include("../userAuth.php");

if(isset($_POST['driverId'])){

    $driver = htmlspecialchars($_POST['driverId']);
    $driver = mysqli_real_escape_string($conn, $driver);
    $driverStatus = htmlspecialchars($_POST['driverStatus']);
    $driverStatus = mysqli_real_escape_string($conn, $driverStatus);

    $q = "SELECT * FROM driver WHERE id = ?";
    $s = $conn->prepare($q);
    $s->bind_param('i', $driver);
    $s->execute();
    $r = $s->get_result();
    if ($r->num_rows === 1) {
        $data = $r->fetch_assoc();
        $isPrinted = $data['isPrinted'];

        if($isPrinted == "true"){

            $printedDate = $data['printedDate'];
            $printedTime = $data['printedTime'];
            $dateObject = DateTime::createFromFormat('Y-n-j', $printedDate);
            $timeObject = DateTime::createFromFormat('H:i:s', $printedTime);

            $dateObject->add(new DateInterval('PT12H'));
            $timeObject->add(new DateInterval('PT12H'));

            $newPrintedDate = $dateObject->format('Y-n-j');
            $newPrintedTime = $timeObject->format('H:i:s');

            
            ?>
            <p class="text-secondary">This vehicle will be removed on <?php echo $newPrintedDate; ?>, at <?php echo $newPrintedTime; ?>.</p>
            <?php
            
        }
    }

    $query = "SELECT * FROM delivery WHERE driverId = ? AND ack_status = 'assigned' ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $driver);
    $stmt->execute();
    $result = $stmt->get_result();

    ?>
    
    <table>
        <tr>
            <td class="font-bold border text-center p-1">Delivery No.</td>
            <td class="font-bold border text-center p-1">STP Code</td>
            <td class="font-bold border text-center p-1">Customer Name</td>
            <td class="font-bold border text-center p-1">Date</td>
            <td class="font-bold border text-center p-1">Created By</td>
            <td class="font-bold border text-center p-1">Remove</td>
        </tr> 
    
        <?php

        while($deliver = $result->fetch_assoc()){
            
            ?>
            
            <tr>
                <td class="border text-center p-1"><?php echo $deliver['delivery_no']; ?></td>
                <td class="border text-center p-1"><?php echo $deliver['stp_code']; ?></td>
                <td class="border text-center p-1"><?php echo $deliver['stp_name']; ?></td>
                <td class="border text-center p-1"><?php echo $deliver['invoice_date']; ?></td>
                <td class="border text-center p-1"><?php echo $deliver['created_by']; ?></td>
                <td class="border text-center p-1">
                    <?php
                    if($driverStatus == "false"){
                        ?>
                            <button class="btn btn-danger" onclick="removeOn('<?php echo $deliver['id']; ?>','<?php echo $deliver['delivery_no']; ?>','<?php echo $deliver['remark']; ?>')" id="deliveryRemoveButton">X</button>
                        <?php
                    }else{
                        ?>
                            <button class="btn btn-secondary pointer-events-none">X</button>
                        <?php
                    }
                    ?>
                </td>
            </tr> 
            
            <?php

        }

        ?>
               
    </table>
    
    <?php

}

?>