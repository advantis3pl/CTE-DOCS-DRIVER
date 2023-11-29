<?php

include("partials/navbar.php");

?>


<p class="border-bottom p-2">STP Reports</p>


<div class="reportsContainer">
    <div class="rasTopBar">
        <h6>Reports</h6>
        <i class="bx:down-arrow text-white"></i>
    </div>

    <p class="text-danger m-3">Only first 30000 records will be printed. Narrow down the date range if it exceeds </p>

    <div class="reportDownloader">
    

        <form post="POST">
            <table>
                <tr>
                    <td class="d-flex stpReportLabel">Report </td>
                    <td class="stpReportLabel">
                        <select name="report" id="report">
                            <option value="distribution_summary_report">Destribution Summary Report</option>
                            <option value="sdr_report">SDR Report</option>
                            <option value="pending_collection_report">Pending Delivery Report</option>
                            <option value="customer_collection_report">Customer Collection Report</option>
                            <option value="special_collection_report">Special Delivery Report</option>
                            <option value="reconcile_report">Reconcile Report</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="d-flex text-center stpReportLabel">From Date</td>
                    <td class="stpReportLabel">
                        <input type="date">
                    </td>
                </tr>

                <tr>
                    <td class="d-flex stpReportLabel">To Date</td>
                    <td class="stpReportLabel">
                        <input type="date">
                    </td>
                </tr>

            </table>    

            <div class="d-flex justify-content-between align-items-center border-top mt-3 pt-3">
                <p></p>
                <div>
                    <button type="submit" class="btn btn-success">Excel</button>
                    <button type="button" class="btn btn-danger">PDF</button>
                </div>
            </div>
        </form> 


    </div>


</div>


<?php

include("partials/footer.php");

?>