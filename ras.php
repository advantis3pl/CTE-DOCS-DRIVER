<?php

include("partials/navbar.php");

?>



<div class="popUpContainer" id="popUpCon">
    <div class="popUpWindow popUpGONE" id="popUpWindow">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
            <h5>Driver Info</h5>
            <button class="btn btn-danger" onclick="closePopUp()">X</button>
        </div>

        <form post="POST">
            <table class="mt-3">
                <tr>
                    <td class="d-flex tableRowName">Driver NIC <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><input type="text" name="driverNIC" id="driverNIC"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Driver Name <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><input type="text" name="driverName" id="driverName"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Mobile No. <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><input type="text" name="driverPhone" id="driverPhone"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Vehicle No. <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><input type="text" name="vehicleN" id="vehicleN"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">No. Of Boxes</td>
                    <td class="tableRowData"><input type="text" name="no_boxes" id="no_boxes"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">No. Of Parcels</td>
                    <td class="tableRowData"><input type="text" name="driverParcels" id="driverParcels"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Log Sheet No.</td>
                    <td class="tableRowData"><input type="text" name="driverSheet" id="driverSheet"></td>
                </tr>
            </table>    

            <div class="d-flex justify-content-between align-items-center border-top mt-3 pt-3">
            <p id="addDriverError" class="text-danger"></p>
            <div>
                <button type="button" class="btn btn-primary" onclick="saveDriverDetails()">Save</button>
                <button type="button" class="btn btn-danger" onclick="closePopUp()">Close</button>
            </div>

            </div>
        </form>
    </div>
</div>


<div class="popUpContainer" id="viewDriverInfo">
    <div class="popUpWindow popUpGONE" id="popUpWindow">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
            <h5>Driver Info</h5>
            <button class="btn btn-danger" onclick="closePopUp()" id="viewDriverXbutton">X</button>
        </div>

        <form post="POST">
            <table class="mt-3">
                <tr>
                    <td class="d-flex tableRowName">Driver NIC <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><input type="text" name="driverNIC_info" id="driverNIC_info"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Driver Name <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><input type="text" name="driverName_info" id="driverName_info"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Mobile No. <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><input type="text" name="driverPhone_info" id="driverPhone_info"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Vehicle No. <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><input type="text" name="vehicleN_info" id="vehicleN_info"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">No. Of Boxes</td>
                    <td class="tableRowData"><input type="text" name="no_boxes_info" id="no_boxes_info"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">No. Of Parcels</td>
                    <td class="tableRowData"><input type="text" name="driverParcels_info" id="driverParcels_info"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Log Sheet No.</td>
                    <td class="tableRowData"><input type="text" name="driverSheet_info" id="driverSheet_info"></td>
                </tr>
            </table>    

            <div class="d-flex justify-content-between align-items-center border-top mt-3 pt-3">
            <p id="addDriverError_info" class="text-danger"></p>
            <div>
                <button type="button" class="btn btn-primary" onclick="updateDriverDetails()" id="updateDriverButton">Update</button>
                <button type="button" class="btn btn-danger" onclick="closePopUp()" id="closeViewDriver">Close</button>
            </div>

            </div>
        </form>
    </div>
</div>


<div class="popUpContainer" id="sdnPopUp">
    <div class="popUpWindow popUpGONE" id="popUpWindow">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
            <h5>Scan Delivery Note</h5>
            <div class="d-flex justify-content-center align-items-center">
                <div id="scanDNLoadingImg" class="d-none">
                    <img src="images/loader.gif" alt="" width="40" height="40" class="p-2">
                </div>
                <button class="btn btn-danger" onclick="closePopUp()" id="scanDNCross">X</button>
            </div>
        </div>

        <form>
            <table class="mt-3">
                <tr>
                    <td class="d-flex tableRowName">Delivery No.  <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><input type="text" name="scanDeliveryNo" id="scanDeliveryNo"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">STP Code </td>
                    <td class="tableRowData"><input type="text" name="scanSTPcode" id="scanSTPcode"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Customer Name </td>
                    <td class="tableRowData"><input type="text" name="scanCustomerName" id="scanCustomerName"></td>
                </tr>
            </table>    

            <div class="d-flex justify-content-between align-items-center border-top mt-3 pt-3">
                <p class="text-danger" id="scanDNError"></p>
                <div>
                    <button type="button" class="btn btn-primary" id="scanDNAssignButton" onclick="assignSDN()">Assign</button>
                    <button type="button" class="btn btn-danger" onclick="closePopUp()" id="scanDNCloseButton">Close</button>
                </div>
            </div>
        </form>
        
    </div>
</div>


<div class="popUpContainer" id="holdPopUp">

    <div class="position-absolute top-0 right-0 bottom-0 left-0">ppp</div>

    <div class="popUpWindow popUpGONE" id="popUpWindow">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
            <h5>Hold Delivery</h5>
            <button class="btn btn-danger" onclick="closePopUp()">X</button>
        </div>

        <form post="POST">
            <table class="mt-3">
                <tr>
                    <td class="d-flex tableRowName">Delivery Date </td>
                    <td class="tableRowData"><input type="text" name="driverNIC" id="driverNIC"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Remark <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><textarea name="driverNIC" id="driverNIC" cols="30" rows="10"></textarea></td>
                </tr>

            </table>    

            <div class="d-flex justify-content-between align-items-center border-top mt-3 pt-3">
                <p></p>
                <div>
                    <button type="submit" class="btn btn-primary">Hold</button>
                    <button type="button" class="btn btn-danger" onclick="closePopUp()">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="popUpContainer" id="removePopUp">
    <div class="popUpWindow popUpGONE" id="popUpWindow">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
            <h5>Remove Delivery</h5>
            <button class="btn btn-danger" onclick="closePopUp()">X</button>
        </div>

        <form post="POST">
            <table class="mt-3">
                <tr>
                    <td class="d-flex tableRowName">Delivery No. </td>
                    <td class="tableRowData"><input type="text" name="driverNIC" id="driverNIC"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Remark <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><textarea name="driverNIC" id="driverNIC" cols="30" rows="10"></textarea></td>
                </tr>

            </table>    

            <div class="d-flex justify-content-between align-items-center border-top mt-3 pt-3">
                <p></p>
                <div>
                    <button type="submit" class="btn btn-primary">Remove</button>
                    <button type="button" class="btn btn-danger" onclick="closePopUp()">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<p class="border-bottom p-2">RAS</p>

<div class="d-flex w-100 h-100">
    
    <div class="routeCon">
        <div class="rasTopBar">
            <h6>Today's Route</h6>
            <i class="bx:down-arrow text-white"></i>
        </div>

        <div class="rcSubCon">
            <table class="w-100">
                <tr>
                    <td class="text-center font-bold border border-dark p-2">Route No.</td>
                    <td class="text-center font-bold border border-dark p-2">Pending Count</td>
                    <td class="text-center font-bold border border-dark p-2">Assigned Count</td>
                </tr>


                <?php

                    $query = "SELECT * FROM route";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $counter = 0;
            
                    while($route = $result->fetch_assoc()){

                        $routeId = $route['id'];

                        $queryPending = "SELECT COUNT(*) FROM delivery WHERE route = ? AND ack_status = 'pending'";
                        $stmtPending = $conn->prepare($queryPending);
                        $stmtPending->bind_param('i', $routeId);
                        $stmtPending->execute();
                        $countPending = $stmtPending->get_result()->fetch_assoc()['COUNT(*)']; 

                        $queryAssigned = "SELECT COUNT(*) FROM delivery
                        WHERE route = ? AND ack_status = 'assigned' AND isPrinted = 'false'";
                        $stmtAssigned = $conn->prepare($queryAssigned);
                        $stmtAssigned->bind_param('i', $routeId);
                        $stmtAssigned->execute();
                        $countAssigned = $stmtAssigned->get_result()->fetch_assoc()['COUNT(*)'];

                        ?>

                        <tr class="routeBarRow" onclick="routeClick('<?php echo $route['id']; ?>','routeBar<?php echo $counter; ?>')" id="routeBar<?php echo $counter;?>">
                            <td class="routeTableBar p-1"><?php echo $route['id']; ?></td>
                            <td class="routeTableBar p-1"><?php echo $countPending; ?></td>
                            <td class="routeTableBar p-1"><?php echo $countAssigned; ?></td>
                        </tr>

                        <input type="text" hidden id="selectedRoute">

                        <?php
                        $counter++;
                    }
                ?>

                
            </table>
        </div>

        <div class="justify-content-center align-items-center d-flex mt-3">
            <button class="btn btn-success">Print All</button>
        </div>

    </div>

    <div class="rasOtherCon">

        <div class="rasOtherSubCon">
            <div class="rasTopBar">
                <h6>Assigned Deliveries</h6>
                <i id="assignedDeliveryLoader"></i>
            </div>

            <div class="assignDelSub">
                <table class="w-100">
                    <tr>
                        <td class="text-center pb-2">Route No. </td>
                        <td class="text-center pb-2"><input type="text" placeholder="Route No." readonly id="loadedRouteNumber"></td>
                        <td class="text-center pb-2">Vehicle No.</td>
                        <td class="text-center pb-2" class="d-flex">
                            <select name="vehicleNumber" id="vehicleNumber" onchange="assignedDeliveryUpdate()">
                                <option value="none"></option>
                            </select>
                            <button class="btn btn-primary" onclick="addVehicle()" id="addVehicleButton"> + </button>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="assignDelSub">
                <div class="assignDelSubTableCon" id="assignedDelDataCon">
                    <table>
                        <tr>
                            <td class="font-bold border text-center p-1">Delivery No.</td>
                            <td class="font-bold border text-center p-1">STP Code</td>
                            <td class="font-bold border text-center p-1">Customer Name</td>
                            <td class="font-bold border text-center p-1">Date</td>
                            <td class="font-bold border text-center p-1">Created By</td>
                            <td class="font-bold border text-center p-1">Remove</td>
                        </tr>                       
                    </table>
                </div>
                <div class="justify-content-center align-items-center d-flex mt-3">
                    <button class="btn btn-success m-2" onclick="turnOnScan()" id="scanDNButton">Scan DN</button>
                    <button class="btn btn-primary m-2" onclick="viewDriverInfo()" id="viewDeliveryButton">View Delivery Info</button>
                    <button class="btn btn-primary m-2" onclick="printAssigned()" id="PrintDNButton">Print</button>
                </div>
            </div>
            
            <p id="assignedDelError" class="text-danger mt-2"></p>

        </div>

        <div class="rasOtherSubCon">
            <div class="rasTopBar">
                <h6>Pending Deliveries</h6>
                <i id="pendingDelLoader"></i>
            </div>
            <div class="assignDelSub">
                <div class="assignPenSubTableCon" id="pendingDataLoader">
                    <table>
                        <tr>
                            <td class="font-bold border text-center p-1">Delivery No.</td>
                            <td class="font-bold border text-center p-1">STP Code</td>
                            <td class="font-bold border text-center p-1">Customer Name</td>
                            <td class="font-bold border text-center p-1">Date</td>
                            <td class="font-bold border text-center p-1">Created By</td>
                            <td class="font-bold border text-center p-1">Remove</td>
                        </tr>
                        
                    </table>
                </div>
                <p class="text-danger mt-2" id="pendingDError"></p>
            </div>
        </div>

    </div>
</div>

<script src="js/rasControler.js"></script>

<?php

include("partials/footer.php");

?>