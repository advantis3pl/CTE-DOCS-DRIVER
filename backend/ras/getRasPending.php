<?php
include("../userAuth.php");

if(isset($_POST['selectedRoute'])){
    $route = htmlspecialchars($_POST['selectedRoute']);
    $route = mysqli_real_escape_string($conn, $route);

    $query = "SELECT * FROM delivery WHERE route = ? AND ack_status = 'pending' ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $route);
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
        while($delivery = $result->fetch_assoc()){

            $classes = "";

            if($delivery['return_status'] == "SDR"){
                $classes = "bg-warning";
            }else if($delivery['return_status'] == "ND"){
                $classes = "bg-danger";
            }else if($delivery['return_status'] == "hold"){
                $classes = "bg-info";
            }else{
                $classes = "";
            }

            ?>
            
            <tr class="<?php echo $classes; ?>">
                <td class="border text-center p-1"><?php echo $delivery['delivery_no']; ?></td>
                <td class="border text-center p-1"><?php echo $delivery['stp_code']; ?></td>
                <td class="border text-center p-1"><?php echo $delivery['stp_name']; ?></td>
                <td class="border text-center p-1"><?php echo $delivery['invoice_date']; ?></td>
                <td class="border text-center p-1"><?php echo $delivery['created_by']; ?></td>
                <td class="border text-center p-1">
                    <button class="btn btn-danger" onclick="turnOnHold('<?php echo $delivery['id']; ?>','<?php echo $delivery['delivery_no']; ?>','<?php echo $delivery['remark']; ?>')" id="deliveryHoldButton">-</button>
                </td>
            </tr>

            <?php
        }
        
        ?>
    </table>

    <?php

}

?>