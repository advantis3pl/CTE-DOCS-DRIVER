<?php
include("partials/navbar.php");
?>

<div class="dashboardcardcontainer mt-3">

	<div class="dashboardwidget disabled">
		<div class="dashboardwidget-value">
			5<span> - Documents</span>
		</div>
		<hr>
		<div class="dashboardwidget-title">
			Total Uploaded Documents
		</div>
	</div>

	<div class="dashboardwidget pass">
		<div class="dashboardwidget-value">
			0<span> - Deliveries</span>
		</div>
		<hr>
		<div class="dashboardwidget-title">
			Total Deliveries Count
		</div>
	</div>
	<div class="dashboardwidget warn">
		<div class="dashboardwidget-value">
			0<span> - Pending</span>
		</div>
		<hr>
		<div class="dashboardwidget-title">
            Deliveries that have a status of pending.
		</div>
	</div>
	<div class="dashboardwidget warn">
		<div class="dashboardwidget-value">
			0<span> - Drivers</span>
		</div>
		<hr>
		<div class="dashboardwidget-title">
			Total number of drivers
		</div>
	</div>
	<div class="dashboardwidget disabled">
		<div class="dashboardwidget-value">
			Last<span> - Login</span>
		</div>
		<hr>
		<div class="dashboardwidget-title">
			<?php echo $user_lastLogin; ?>
		</div>
	</div>
</div>

<div class="m-3 mt-4">
    <div class="d-flex">
        <div style="width: 50%; padding:10px;">
            <p class="text-secondary border-bottom">Login History</p>
            <table class="table table-bordered table-striped" style="width: 100%;">
                <thead class="bg-info">
                    <tr>
                        <th>Username</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    
                    $sql = "SELECT * FROM login_history WHERE user_sk = ? ORDER BY id DESC LIMIT 10";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $userId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($hs_row = $result->fetch_assoc()) {
                        ?>
                        
                        <tr>
                            <td><?php echo $hs_row['username']; ?></td>
                            <td><?php echo $hs_row['login_time']; ?></td>
                        </tr>
                        
                        <?php
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>

        <div style="width: 50%; padding:10px;">
            <p class="text-secondary border-bottom">User Actions</p>
            <table class="table table-bordered table-striped" style="width: 100%;">
                <thead class="bg-info">
                    <tr>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Adithya</td>
                        <td>2023-11-23 11:11:55</td>
                    </tr>
                    <tr>
                        <td>Adithya</td>
                        <td>2023-11-23 11:11:55</td>
                    </tr>
                    <tr>
                        <td>Adithya</td>
                        <td>2023-11-23 11:11:55</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



</body>





<?php
include("partials/footer.php");
?>