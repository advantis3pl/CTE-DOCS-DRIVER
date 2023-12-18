<?php
include("../userAuth.php");

if(isset($_POST['selectedRoute'])){
    $route = htmlspecialchars($_POST['selectedRoute']);
    $route = mysqli_real_escape_string($conn, $route);

    date_default_timezone_set('Asia/Colombo');
    $currentDate = date('Y-n-j');

    $query = "SELECT * FROM driver WHERE route = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $route);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>
    
        <option value="none"></option>
        
        <?php
        while($driver = $result->fetch_assoc()){

            $createdDate = $driver['created_date'];
            $isPrinted = $driver['isPrinted'];

            if($isPrinted == "false"){
                ?>
                <option value="<?php echo $driver['id']; ?>"><?php echo $driver['vehicle']; ?></option>
                <?php
            }

            /*if($currentDate == $createdDate){

                ?>
                <option value="<?php echo $driver['id']; ?>"><?php echo $driver['vehicle']; ?></option>
                <?php
                
            }else{
                $assignedStatus = "assigned";
                $q = "SELECT * FROM delivery WHERE driverId = ? AND ack_status = ?";
                $s = $conn->prepare($q);
                $s->bind_param('is', $driver['id'],$assignedStatus);
                $s->execute();
                $r = $s->get_result();
                if ($r->num_rows != 0) {
                    ?>
                    <option value="<?php echo $driver['id']; ?>"><?php echo $driver['vehicle']; ?></option>
                    <?php
                }

            }*/
        }
        ?>




    <?php

}

?>