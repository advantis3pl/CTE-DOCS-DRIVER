<?php
include("../userAuth.php");

if(isset($_POST['driverIdToPrint'])){
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
            $noOfBoxes = $driver['no_box'];
            $noOfParcels = $driver['no_parcel'];
            $nameOfDeliveryMan = $driver['name'];
            $driverNIC = $driver['nic'];
            $logSheetNumber = $driver['log_no'];
            date_default_timezone_set('Asia/Colombo');
            $date = date('Y-n-j');
            $phone = $driver['phone'];

            if($noOfBoxes == 0 && $noOfParcels == 0){
                echo 501;
            }else{
                ?>
                <div id="downloadDiv">

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
                                <tr class="border-bottom">
                                    <td>Log Sheet No:</td>
                                    <td><?php echo $logSheetNumber; ?></td>
                                </tr>
                            </table>
                        </div>

                        <table class="w-100 mt-3">
                            <tr class="mb-2 no-break">
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
                                
                                <tr class="no-break">
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


                        <div class="justify-content-between align-items-center d-flex pt-3 no-break">

                            <div class="border border-dark w-50">

                                <table class="mt-3 w-100">
                                    <tr class="border-bottom border-dark">
                                        <td class="p-2">No of Boxes</td>
                                        <td class="p-2"><?php echo $noOfBoxes; ?></td>
                                    </tr>
                                    <tr class="border-bottom border-dark">
                                        <td class="p-2">No of Parcels</td>
                                        <td class="p-2"><?php echo $noOfParcels; ?></td>
                                    </tr>
                                    <tr class="border-bottom border-dark">
                                        <td class="p-2">Name of Deliveryman</td>
                                        <td class="p-2"><?php echo $nameOfDeliveryMan; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="p-2">NIC of Deliveryman</td>
                                        <td class="p-2"><?php echo $driverNIC; ?></td>
                                    </tr>
                                </table>

                            </div>

                            <div class="w-25"></div>

                            <div class="border border-dark w-25">

                                <table class="mt-3 w-100">
                                    <tr>
                                        <td class="p-2">________________</td>
                                    </tr>

                                    <tr>
                                        <td class="p-2 border-bottom border-dark">Signature of Deliveryman</td>
                                    </tr>

                                    <tr>
                                        <td class="p-2">________________</td>
                                    </tr>

                                    <tr>
                                        <td class="p-2">Summary checked by</td>
                                    </tr>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
                <?php

            }

        }else{
            echo 500;
        }
}else{
    echo 500;
}

?>
