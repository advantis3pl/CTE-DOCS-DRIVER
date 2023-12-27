<?php

include("partials/navbar.php");

?>

<div class="pt-3">
    <div class="panel panel-info">

        <div class="panel-heading">
            <h4 class="panel-titleText">
                Update Pending Delivery
            </h4>
        </div>

        <div class="panel-wrapper">
            <div class="panel-body">
                <div class="updateFormCon border p-3">
                    <form method="POST" class="updateForm" id="updatePendingDNForm">
                        <div class="updateFormControl">
                            <label>Delivery No. : </label>
                            <input type="text" class="iw60" id="deliveryNumberInput">
                            <button class="btn btn-secondary" onclick="addDeliveryNoByButton()" class="d-block" id="addButtonUDN">
                                Add
                            </button>
                        </div>
                    </form>

                    <p class="text-danger" id="scanDNErrorUP"></p>


                    <div id="pendingAddedList">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="border border-dark">Delivery No.</th>
                                    <th class="border border-dark">STP Code</th>
                                    <th class="border border-dark">Customer Name</th>
                                    <th class="border border-dark">Remark</th>
                                    <th class="border border-dark">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="justify-content-between align-items-center d-flex mb-5">
                        <p></p>
                        <button class="border btn btn-secondary" type="button" onclick="clearAllAdded()" id="clearAllButton">Clear All</button>
                    </div>

                    <div class="updateFormControl">
                        <label>Remark All : </label>
                        <textarea name="remarkAll" id="remarkAll" rows="5"></textarea>
                    </div>

                    <div class="updateFormActions">
                        <button type="button" class="btn btn-danger mr-2" id="invoiceButton" onclick="updatePending('IC')">Invoice Cancellation</button>
                        <button type="button" class="btn btn-success mr-2" id="specialDNButton" onclick="updatePending('SD')">Special Delivery</button>
                        <button type="button" class="btn btn-primary" id="CustomerCButton" onclick="updatePending('CC')">Customer Collection</button>
                    </div>

                    <p class="text-danger" id="updateError"></p>
                    <p class="text-success" id="updateSuccess"></p>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/updatePending.js?v=2"></script>

<?php

include("partials/footer.php");

?>