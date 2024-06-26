<?php

include("partials/navbar.php");
include("partials/adminAuth.php");

if(isset($_GET['id'])){
    $history_username = $_GET['id'];

    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $history_username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $userData = $result->fetch_assoc();
        ?>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <div class="justify-content-center align-items-center d-flex">

            <input type="text" hidden id="huid" value="<?php echo $userData['id']; ?>">
            <input type="text" hidden id="huusername" value="<?php echo $history_username;?>">

            <div class="w-100">
                <h4>Login History (<?php echo $history_username; ?>) <a href="users.php"> < Back to Users</a></h4>
                <table class="w-100 table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td class="font-bold">Username</td>
                            <td class="font-bold">Login Time</td>
                        </tr>
                    </thead>
                    <tbody id="userLogins">

                    </tbody>
                </table>

                <div id="loadingIndicator" style="display: none; text-align: center;">
                    Loading...
                </div>
            </div>
    
        </div>


        <script>
            
            $(document).ready(function() {
                var loading = false;
                var dataLimit = 25;
                var lastRecordId = 0; // Initialize with the initial value
                var username = document.getElementById("huusername").value;
                var working = true;

                function loadMoreData() {
                    console.log(lastRecordId);
                    if (working) {
                        loading = true;
                        $('#loadingIndicator').show();

                        $.ajax({
                            url: 'backend/history/loginHistory.php',
                            method: 'POST',
                            data: { username: username, limit: dataLimit, lastRecordId: lastRecordId },
                            dataType: 'json',
                            success: function(response) {
                                if (response.length === 0) {
                                    $('#loadingIndicator').text("No more data.");
                                    working = false;
                                    loading = false;
                                    return;
                                }

                                $.each(response, function(index, row) {
                                    $('#userLogins').append(`
                                        <tr>
                                            <td>${row.id}</td>
                                            <td>${row.login_time}</td>
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