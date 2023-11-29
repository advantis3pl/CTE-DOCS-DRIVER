<?php

include("partials/navbar.php");

?>

<div class="border-bottom p-2">Report</div>

<div class="p-4">
    <div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-titleText">
                    Upload SAP report
                    <div class="pull-right">
                        <a href="#" data-perform="panel-collapse" class="btn btn-primary btn-xs pull-right"><i class="fa fa-plus"></i></a>
                    </div>
                </h4>
            </div>

            <div class="panel-wrapper collapse position-relative">

                <div class="w-100 position-absolute top-0 right-0 bottom-0 left-0 bg-light justify-content-center align-items-center flex-column d-none" id="sapReportUplaodLoader">
                    <img src="images/loader.gif" alt="" width="40" height="40">
                    <p class="text-secondary mt-2">Processing...</p>
                </div>

                <div class="panel-body">
                    <div class="border p-3">
                        <form method="POST" id="SAPUploadform">
                            <p class="text-secondary">Upload your genearted file from the SAP here</p>

                            <div class="d-flex border p-2">
                                <label>SAP Report</label>
                                <input type="file" name="sapReportFile" id="sapReportFile" required>
                                <button type="submit" class="btn btn-primary">Validate & Upload</button>
                            </div>

                        </form> 
                    </div>
                    <p class="text-danger mt-2" id="sapReportError"></p>
                </div>
            </div>
        </div>
    </div>



    <div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-titleText">
                    Factory Invoices 
                    <div class="pull-right">
                        <a href="#" data-perform="panel-collapse" class="btn btn-primary btn-xs pull-right"><i class="fa fa-plus"></i></a>
                    </div>
                </h4>
            </div>

            <div class="panel-wrapper collapse position-relative">

                <div class="w-100 position-absolute top-0 right-0 bottom-0 left-0 bg-light justify-content-center align-items-center flex-column d-none" id="factoryInvoiceUploadLoader">
                    <img src="images/loader.gif" alt="" width="40" height="40">
                    <p class="text-secondary mt-2">Processing...</p>
                </div>

                <div class="panel-body">
                    <div class="border p-3">
                        <form method="POST" id="factoryInvoiceForm">
                            <p class="text-danger">This is used to upload deliveries invoiced from other user IDs (which are invoiced from factory) </p>
                            <div class="d-flex border p-2">
                                <label>Factory Invoice</label>
                                <input type="file" name="factoryInvoiceFile" id="factoryInvoiceFile">
                                <button type="submit" class="btn btn-primary">Validate & Upload</button>
                            </div>
                        </form>
                    </div>
                    <p class="text-danger mt-2" id="factoryInvoiceError"></p>
                </div>
            </div>
        </div>
    </div>



    <div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-titleText">
                    Update Pending Delivery
                    <div class="pull-right">
                        <a href="#" data-perform="panel-collapse" class="btn btn-primary btn-xs pull-right"><i class="fa fa-plus"></i></a>
                    </div>
                </h4>
            </div>

            <div class="panel-wrapper collapse">
                <div class="panel-body">
                    <div class="updateFormCon border p-3">
                        <form method="POST" class="updateForm">

                        <div class="updateFormControl">
                            <label>Delivery No. : </label>
                            <input type="text" class="iw60">
                            <button class="btn btn-secondary">Search</button>
                        </div>

                        <div class="updateFormControl">
                            <label>STP Code : </label>
                            <input type="text" class="iw80">
                        </div>

                        <div class="updateFormControl">
                            <label>Customer Name : </label>
                            <input type="text" class="iw80">
                        </div>

                        <div class="updateFormControl">
                            <label>Remark : </label>
                            <textarea name="remark" id="remark" rows="5"></textarea>
                        </div>

                        <div class="updateFormActions">
                            <button type="button" class="btn btn-danger mr-2">Invoice Cancellation</button>
                            <button type="button" class="btn btn-success mr-2">Special Delivery</button>
                            <button type="button" class="btn btn-primary">Customer Collection</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-titleText">
                    Delivery History 
                    <div class="pull-right">
                        <a href="#" data-perform="panel-collapse" class="btn btn-primary btn-xs pull-right"><i class="fa fa-plus"></i></a>
                    </div>
                </h4>
            </div>

            <div class="panel-wrapper collapse">
                <div class="panel-body">
                    <div class="updateFormCon border p-3">
                        <form method="POST" class="updateForm">
                            <div class="updateFormControl">
                                <label>Delivery No. : </label>
                                <input type="text" class="iw60">
                                <button class="btn btn-secondary">Search</button>
                            </div>

                            <div class="updateFormControl">
                                <label>STP Code : </label>
                                <input type="text" class="iw80">
                            </div>

                            <div class="updateFormControl">
                                <label>Customer Name : </label>
                                <input type="text" class="iw80">
                            </div>

                            <div class="updateFormControl">
                                <label>Current Status : </label>
                                <input type="text" class="iw80">
                            </div>

                            <div class="updateFormControl">
                                <label>Remark : </label>
                                <textarea name="remark" id="remark" rows="5"></textarea>
                            </div>
                        </form>
                    </div>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Action</th>
                            <th>Date/Time</th>
                            <th>User</th>
                            <th>Remarks</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Create</td>
                            <td>2023-11-09 10:00 AM</td>
                            <td>User123</td>
                            <td>Initial creation</td>
                        </tr>
                        <tr>
                            <td>Create</td>
                            <td>2023-11-09 10:00 AM</td>
                            <td>User123</td>
                            <td>Initial creation</td>
                        </tr>
                        <tr>
                            <td>Create</td>
                            <td>2023-11-09 10:00 AM</td>
                            <td>User123</td>
                            <td>Initial creation</td>
                        </tr>
                        <tr>
                            <td>Create</td>
                            <td>2023-11-09 10:00 AM</td>
                            <td>User123</td>
                            <td>Initial creation</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>




</div>

<script src="js/uploadSAP.js"></script>
<script src="js/uploadFactoryInvoice.js"></script>

<?php
include("partials/footer.php");
?>