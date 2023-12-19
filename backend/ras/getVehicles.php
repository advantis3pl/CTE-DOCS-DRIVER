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



            $printedTime = $driver['printedTime'];
            $printedDate = $driver['printedDate'];

            if($isPrinted == "true"){

                date_default_timezone_set('Asia/Colombo');

                $printedDateTimeString = "$printedDate $printedTime";
                $printedDateTime = DateTime::createFromFormat('Y-n-j H:i:s', $printedDateTimeString);
                $currentDateTime = new DateTime();
                $interval = $printedDateTime->diff($currentDateTime);
                $hoursDifference = $interval->h + ($interval->days * 24);
                
                if($hoursDifference < 12){
                    ?>
                    <option value="<?php echo $driver['id']; ?>"><?php echo $driver['vehicle']; ?></option>
                    <?php
                }

            }else{
                ?>
                    <option value="<?php echo $driver['id']; ?>"><?php echo $driver['vehicle']; ?></option>
                <?php
            }

        }
        ?>




    <?php

}

?>