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
                            <p class="text-secondary">Upload factory invoices here. </p>
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
</div>

<script src="js/uploadSAP.js?v=2"></script>
<script src="js/uploadFactoryInvoice.js?v=2"></script>

<?php
include("partials/footer.php");
?>