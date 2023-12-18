<?php
include("../userAuth.php");

if(isset($_POST['driverIdToPrint'])){
?>

<div id="downloadDiv">

    <?php

        $driverId = $_POST['driverIdToPrint'];

        $query = "SELECT * FROM driver WHERE id = ? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $driverId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $driver = $result->fetch_assoc();


            $route = $driver['route'];
            $vehicle = $driver['vehicle'];
            date_default_timezone_set('Asia/Colombo');
            $date = date('Y-n-j');
            $phone = $driver['phone'];
            

            ?>
            

            <div class="p-3">

                <h2 class="text-center">Route Allocation Sheet</h2>
                <div class="border border-dark p-2 d-flex">
                    <table class="w-50 m-3">
                        <tr class="border-bottom">
                            <td>Zone No:</td>
                            <td><?php echo $route; ?></td>
                        </tr>
                        <tr class="border-bottom">
                            <td>Vehicle No:</td>
                            <td><?php echo $vehicle; ?></td>
                        </tr>
                        <tr class="border-bottom">
                            <td>Date:</td>
                            <td><?php echo $date; ?></td>
                        </tr>
                        <tr class="border-bottom">
                            <td>Mobile No:</td>
                            <td><?php echo $phone; ?></td>
                        </tr>
                    </table>

                    <table class="w-25 m-3">
                        <tr class="border-bottom">
                            <td>RA No:</td>
                            <td><?php echo $driverId; ?></td>
                        </tr>
                    </table>
                </div>

                <table class="w-100 mt-3">
                    <tr class="mb-2">
                        <td class="border-bottom border-dark">No.</td>
                        <td class="border-bottom border-dark">Delivery No</td>
                        <td class="border-bottom border-dark">STC</td>
                        <td class="border-bottom border-dark">Customer Name</td>
                        <td class="border-bottom border-dark">Created By</td>
                    </tr>

                    <?php

                    $counter = 0;
                    
                    $q = "SELECT * FROM delivery WHERE driverId = ? ";
                    $s = $conn->prepare($q);
                    $s->bind_param('i', $driverId);
                    $s->execute();
                    $r = $s->get_result();
                    while($record = $r->fetch_assoc()){
                        $counter++;
                        ?>
                        
                        <tr>
                            <td><?php echo $counter; ?></td>
                            <td><?php echo $record['delivery_no']; ?></td>
                            <td><?php echo $record['stp_code']; ?></td>
                            <td><?php echo $record['stp_name']; ?></td>
                            <td><?php echo $record['created_by']; ?></td>
                        </tr>

                        <?php
                    }
                    
                    ?>
                </table>

            </div>

            
            <?php



            }else{
                echo 500;
            }

    ?>

</div>

<?php

}else{
    echo 500;
}

?>
