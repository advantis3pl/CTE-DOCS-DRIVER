<?php
include("../userAuth.php");

if(isset($_POST['driverId'])){

    $driver = htmlspecialchars($_POST['driverId']);
    $driver = mysqli_real_escape_string($conn, $driver);

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
                    <button class="btn btn-danger" onclick="removeOn('<?php echo $deliver['id']; ?>')" id="deliveryRemoveButton">X</button>
                </td>
            </tr> 
            
            <?php

        }

        ?>
               
    </table>
    
    <?php

}

?>