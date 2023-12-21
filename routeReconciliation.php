<?php

include("partials/navbar.php");

?>

<div class="popUpContainer" id="nddnPopUp">
    <div class="popUpWindow popUpGONE" id="popUpWindow">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
            <h5>Not Delivered</h5>
            <button class="btn btn-danger" onclick="closeRRPopUp()" id="nddnCross">X</button>
        </div>

        <form post="POST">
            <table class="mt-3">
                <tr>
                    <td class="d-flex tableRowName">Delivery No </td>
                    <td class="tableRowData"><input type="text" name="nddnDeliveryNumber" id="nddnDeliveryNumber" readonly></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Remark <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><textarea name="nddnRemark" id="nddnRemark" cols="30" rows="10"></textarea></td>
                </tr>

            </table>    

            <div class="d-flex justify-content-between align-items-center border-top mt-3 pt-3">
                <p class="text-danger" id="nddnError"></p>
                <div>
                    <button type="button" class="btn btn-primary" onclick="UpdateAsNotDeliveredDN()" id="nddnSubmitBtn">Not Delivered DN</button>
                    <button type="button" class="btn btn-danger" onclick="closeRRPopUp()" id="nddnCloseBtn">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="popUpContainer" id="sdrPopUp">
    <div class="popUpWindow popUpGONE" id="popUpWindow">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
            <h5>Same Day Return</h5>
            <button class="btn btn-danger" onclick="closeRRPopUp()" id="sdrCross">X</button>
        </div>

        <form post="POST">
            <table class="mt-3">
                <tr>
                    <td class="d-flex tableRowName">Delivery No </td>
                    <td class="tableRowData"><input type="text" name="sdrDeliveryNumber" id="sdrDeliveryNumber" readonly></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Remark <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><textarea name="sdrRemark" id="sdrRemark" cols="30" rows="10"></textarea></td>
                </tr>

            </table>    

            <div class="d-flex justify-content-between align-items-center border-top mt-3 pt-3">
                <p class="text-danger" id="sdrError"></p>
                <div>
                    <button type="button" class="btn btn-primary" onclick="UpdateAsSameDayReturn()" id="sdrSubmitButton">Same Day Return</button>
                    <button type="button" class="btn btn-danger" onclick="closeRRPopUp()" id="sdrCloseBtn">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>


<p class="border-bottom p-2">Route Reconciliation</p>


<div class="d-flex w-100 h-100">
    
    <div class="routeCon">
        <div class="rasTopBar">
            <h6>Today's Route</h6>
            <i class="bx:down-arrow text-white"></i>
        </div>

        <div class="rcSubCon">

            <div class="p-3 justify-content-center align-items-center d-flex rrSearchCon">
                <input type="date" id="rrDateInput" name="rrDateInput">
                <button class="btn btn-secondary" onclick="getDataBySearch()">Search</button>
            </div>

            <table class="w-100" id="rrRouteList">
                <tr>
                    <td class="text-center font-bold border border-dark">Route No.</td>
                </tr>

                <?php
                
                    $query = "SELECT * FROM route";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $counter = 0;
            
                    while($route = $result->fetch_assoc()){
                        $routeId = $route['id'];
                        ?>
                        
                        <tr class="routeBarRow">
                            <td class="routeTableBar" onclick="rrSelectRoute('<?php echo $routeId; ?>','routeSelector<?php echo $routeId; ?>')" id="routeSelector<?php echo $routeId; ?>"><?php echo $routeId; ?></td>
                        </tr>
                        
                        <?php
                    }
                ?>    
            </table>
        </div>
    </div>

    <div class="rasOtherCon">

        <div class="rasOtherSubCon">
            <div class="rasTopBar">
                <h6>Route Plan</h6>
                <i class="bx:down-arrow text-white"></i>
            </div>

            <div class="assignDelSub">
                <div class="assignDelSubTableCon" id="rrRouteVehicleContainer">
                    <table>
                        <tr>
                            <td class="font-bold border text-center p-1">Vehicle</td>
                            <td class="font-bold border text-center p-1">Driver</td>
                            <td class="font-bold border text-center p-1">NIC</td>
                            <td class="font-bold border text-center p-1">No. Boxes</td>
                            <td class="font-bold border text-center p-1">No. Parcels</td>
                            <td class="font-bold border text-center p-1">Log Sheet</td>
                            <td class="font-bold border text-center p-1">Dispatch Time</td>
                        </tr>
                    </table>
                </div>
            </div>
            

        </div>

        <div class="rasOtherSubCon">
            <div class="rasTopBar">
                <h6>Assigned Deliveries</h6>
                <i class="bx:down-arrow text-white"></i>
            </div>
            <div class="assignDelSub">
                <div class="assignPenSubTableCon" id="rrAssignedDeliveryContainer">
                    <table>
                        <tr>
                            <td class="font-bold border text-center p-1">Delivery No</td>
                            <td class="font-bold border text-center p-1">STP Code</td>
                            <td class="font-bold border text-center p-1">Customer Name</td>
                            <td class="font-bold border text-center p-1">Ack Status</td>
                        </tr>
                        
                    </table>
                </div>
                <div class="justify-content-center align-items-center d-flex mt-3">
                    <button class="btn btn-danger m-2" id="NDButton" onclick="notDeliveredDn()">Not Delivered DN</button>
                    <button class="btn btn-success m-2" id="SDRButton" onclick="sameDayReturnDN()">Same Day Return</button>
                </div>
            </div>
        </div>


        <div class="rasOtherSubCon">
            <div class="rasTopBar">
                <h6>Return Deliveries</h6>
                <i class="bx:down-arrow text-white"></i>
            </div>
            <div class="assignDelSub">
                <div class="assignPenSubTableCon" id="rrReturnDeliveryContainer">
                    <table>
                        <tr>
                            <td class="font-bold border text-center p-1">Delivery No</td>
                            <td class="font-bold border text-center p-1">STP Code</td>
                            <td class="font-bold border text-center p-1">Customer Name</td>
                            <td class="font-bold border text-center p-1">Type</td>
                        </tr>
                        
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<!--hidden inputs-->
<input type="text" hidden name="rrSelectedRoute" id="rrSelectedRoute">
<input type="text" hidden name="selectedVehicleId" id="selectedVehicleId">
<input type="text" hidden name="selectedDeliveryId" id="selectedDeliveryId">
<input type="text" hidden name="selectedDeliveryNumber" id="selectedDeliveryNumber">

<script src="js/rrController.js"></script>
<?php

include("partials/footer.php");

?>