<?php

include("partials/navbar.php");
include("partials/adminAuth.php");


if(isset($_GET['id'])){
    $history_userId = $_GET['id'];

    $query = "SELECT * FROM user WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $history_userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $userData = $result->fetch_assoc();
        $actionUsername = $userData['username'];
        ?>
        
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <div class="justify-content-center align-items-center d-flex">

            <input type="text" hidden name="huid" id="huid" value="<?php echo $history_userId; ?>">

            <div class="w-100">
                <h4>Login History (<?php echo $actionUsername; ?>) <a href="users.php"> < Back to Users</a></h4>
                


                <table class="w-100 table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="font-bold">Delivery Number</th>
                        <th class="font-bold">Date / Time</th>
                        <th class="font-bold">Action</th>
                        <th class="font-bold">Remark</th>
                    </tr>
                </thead>
                <tbody id="loadingAppend">
                    <?php
                    // Your PHP code for initial data load
                    ?>
                </tbody>
            </table>
            <!-- Loading indicator -->
            <div id="loadingIndicator" style="display: none; text-align: center;">
                Loading...
            </div>
            </div>
    
        </div>




        <script>
            
            $(document).ready(function() {
                var loading = false;
                var dataLimit = 100;
                var lastRecordId = 0; // Initialize with the initial value
                var userId = document.getElementById("huid").value;
                var working = true;

                function loadMoreData() {
                    if(working){
                        loading = true;
                        $('#loadingIndicator').show();

                        $.ajax({
                            url: 'backend/history/loadActions.php',
                            method: 'POST',
                            data: { uid: userId, limit: dataLimit, lastRecordId: lastRecordId },
                            dataType: 'json',
                            success: function(response) {
                                if (response.length === 0) {
                                    $('#loadingIndicator').text("No more data.");
                                    working = false;
                                    loading = false;
                                    return;
                                }

                                $.each(response, function(index, row) {
                                    $('#loadingAppend').append(`
                                        <tr>
                                            <td>${row.delivery_number}</td>
                                            <td>${row.action_date +" / "+ row.action_time}</td>
                                            <td>${row.action}</td>
                                            <td>${row.remark}</td>
                                        </tr>
                                    `);
                                    lastRecordId = row.id;
                                });
                                $('#loadingIndicator').hide();
                                loading = false;
                            },
                            error: function() {
                                $('#loadingIndicator').hide();
                                loading = false;
                            }
                        });
                    }
                }

                // Initial load of data
                loadMoreData();

                $(window).scroll(function() {
                    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100 && !loading) {
                        loadMoreData();
                    }
                });
            });



        </script>

        
        
        <?php

    }else{
        ?>
        <p class="text-secondary p-4">Error! User not found.</p>
        <?php
    }

}else{
    ?>
    <p class="text-secondary p-4">Error! User not found.</p>
    <?php
}

?>


<?php
include("partials/footer.php");
?>