<?php
include("partials/navbar.php");
?>
<div>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4 class="panel-titleText">
                Delivery History 
            </h4>
        </div>

        <div class="panel-wrapper">
            <div class="panel-body">
                <div class="updateFormCon border p-3">
                    <form method="POST" class="updateForm" id="dHSearchForm">
                        <div class="updateFormControl">
                            <label>Delivery No. : </label>
                            <input type="text" class="iw60" id="dhScanDeliveryInput">
                            <button class="btn btn-secondary" id="searchDHButton">Search</button>
                        </div>

                        <div class="updateFormControl">
                            <label>STP Code : </label>
                            <input type="text" class="iw80" readonly id="dhStpCode">
                        </div>

                        <div class="updateFormControl">
                            <label>Customer Name : </label>
                            <input type="text" class="iw80" readonly id="dhCustomerName">
                        </div>

                        <div class="updateFormControl">
                            <label>Status : </label>
                            <input type="text" class="iw80" readonly id="dhStatus">
                        </div>

                        <div class="updateFormControl">
                            <label>Scan Status: </label>
                            <input type="text" class="iw80" readonly id="dhScanStatus">
                        </div>

                        <div class="updateFormControl">
                            <label>Remark : </label>
                            <textarea id="dhRemark" rows="5" readonly></textarea>
                        </div>
                    </form>

                    <p class="text-danger" id="dHSearchError"></p>
                </div>

                <table class="table table-striped" id="dhActionTable">
                    <thead>
                    <tr>
                        <th>Action</th>
                        <th>Date/Time</th>
                        <th>User</th>
                        <th>Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<script src="js/deliveryHistory.js"></script>
<?php
include("partials/footer.php");
?>