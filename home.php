<?php
include("partials/navbar.php");
?>

<div class="dashboardcardcontainer mt-3">

	<div class="dashboardwidget disabled">
		<div class="dashboardwidget-value">

        <?php
        
        $sql = "SELECT COUNT(*) as count FROM delivery_report";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $recordCount = $row['count'];
        echo number_format($recordCount);
        
        ?>
        <span> - Documents</span>
		</div>
		<hr>
		<div class="dashboardwidget-title">
			Total Uploaded Documents
		</div>
	</div>

	<div class="dashboardwidget pass">
		<div class="dashboardwidget-value">
			
        <?php
        
        $sql = "SELECT COUNT(*) as count FROM delivery";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $recordCount = $row['count'];
        echo number_format($recordCount);
        
        ?>
        
        <span> - Deliveries</span>
		</div>
		<hr>
		<div class="dashboardwidget-title">
			Total Deliveries Count
		</div>
	</div>
	<div class="dashboardwidget warn">
		<div class="dashboardwidget-value">
		
        <?php
        
        $sql = "SELECT COUNT(*) as count FROM delivery WHERE ack_status = 'pending'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $recordCount = $row['count'];
        echo number_format($recordCount);
        
        ?>
        
        <span> - Pending</span>
		</div>
		<hr>
		<div class="dashboardwidget-title">
            Total number of pending deliveries
		</div>
	</div>
	<div class="dashboardwidget warn">
		<div class="dashboardwidget-value">
		
        <?php
        
        $sql = "SELECT COUNT(*) as count FROM client WHERE status = 'active'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $recordCount = $row['count'];
        echo number_format($recordCount);
        
        ?>

        <span> - Clients</span>
		</div>
		<hr>
		<div class="dashboardwidget-title">
			Total number of active clients
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
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    
                    $sql = "SELECT * FROM delivery_action WHERE user = ? ORDER BY id DESC LIMIT 10";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $userDbId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($hs_row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $username; ?></td>
                                <td><?php echo $hs_row['delivery_number'] . " - " . $hs_row['action']; ?></td>
                                <td><?php echo $hs_row['action_date'] . " " . $hs_row['action_time']; ?></td>
                            </tr>
                        <?php
                    }
                    
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>



</body>





<?php
include("partials/footer.php");
?>