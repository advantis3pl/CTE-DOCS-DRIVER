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
                    <td class="tableRowData"><input type="text" name="driverNIC" id="driverNIC"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Mobile No. <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><input type="text" name="driverNIC" id="driverNIC"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Vehicle No. <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><input type="text" name="driverNIC" id="driverNIC"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">No. Of Boxes</td>
                    <td class="tableRowData"><input type="text" name="driverNIC" id="driverNIC"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">No. Of Parcels</td>
                    <td class="tableRowData"><input type="text" name="driverNIC" id="driverNIC"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Log Sheet No.</td>
                    <td class="tableRowData"><input type="text" name="driverNIC" id="driverNIC"></td>
                </tr>
            </table>    

            <div class="d-flex justify-content-between align-items-center border-top mt-3 pt-3">
                <p></p>
                <div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" onclick="closePopUp()">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="popUpContainer" id="sdnPopUp">
    <div class="popUpWindow popUpGONE" id="popUpWindow">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
            <h5>Scan Delivery Note</h5>
            <button class="btn btn-danger" onclick="closePopUp()">X</button>
        </div>

        <form post="POST">
            <table class="mt-3">
                <tr>
                    <td class="d-flex tableRowName">Delivery No.  <b class="text-danger"> &nbsp *</b></td>
                    <td class="tableRowData"><input type="text" name="driverNIC" id="driverNIC"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">STP Code </td>
                    <td class="tableRowData"><input type="text" name="driverNIC" id="driverNIC"></td>
                </tr>

                <tr>
                    <td class="d-flex tableRowName">Customer Name </td>
                    <td class="tableRowData"><input type="text" name="driverNIC" id="driverNIC"></td>
                </tr>
            </table>    

            <div class="d-flex justify-content-between align-items-center border-top mt-3 pt-3">
                <p></p>
                <div>
                    <button type="submit" class="btn btn-primary">Assign</button>
                    <button type="button" class="btn btn-danger" onclick="closePopUp()">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="popUpContainer" id="holdPopUp">
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


<p class="border-bottom p-2">Route Reconciliation</p>


<div class="d-flex w-100 h-100">
    
    <div class="routeCon">
        <div class="rasTopBar">
            <h6>Today's Route</h6>
            <i class="bx:down-arrow text-white"></i>
        </div>

        <div class="rcSubCon">

            <div class="p-3 justify-content-center align-items-center d-flex rrSearchCon">
                <input type="date">
                <button class="btn btn-secondary">Search</button>
            </div>

            <table class="w-100">
                <tr>
                    <td class="text-center font-bold border border-dark">Route No.</td>
                </tr>

                <tr class="routeBarRow">
                    <td class="routeTableBar">1</td>
                </tr>
                <tr class="routeBarRow">
                    <td class="routeTableBar">1</td>
                </tr>
                <tr class="routeBarRow">
                    <td class="routeTableBar">1</td>
                </tr>
                <tr class="routeBarRow">
                    <td class="routeTableBar">1</td>
                </tr>
                <tr class="routeBarRow">
                    <td class="routeTableBar">1</td>
                </tr>
                <tr class="routeBarRow">
                    <td class="routeTableBar">1</td>
                </tr>
                <tr class="routeBarRow">
                    <td class="routeTableBar">1</td>
                </tr>
                <tr class="routeBarRow">
                    <td class="routeTableBar">1</td>
                </tr>
                <tr class="routeBarRow">
                    <td class="routeTableBar">1</td>
                </tr>
                <tr class="routeBarRow">
                    <td class="routeTableBar">1</td>
                </tr>
                <tr class="routeBarRow">
                    <td class="routeTableBar">1</td>
                </tr>
                
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
                <div class="assignDelSubTableCon">
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
                <div class="assignPenSubTableCon">
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
                    <button class="btn btn-danger m-2" >Not Delivered DN</button>
                    <button class="btn btn-success m-2" >Same Day Return</button>
                </div>
            </div>
        </div>

    </div>
</div>

<?php

include("partials/footer.php");

?>