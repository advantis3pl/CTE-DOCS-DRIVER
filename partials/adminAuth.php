<?php

if(isset($_SESSION['user_id'])){

    $userId = $_SESSION['user_id'];
    
    $query = "SELECT * FROM user WHERE userKey = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows != 1) {

        session_destroy();
        ?>
        <script>
            window.location.replace("login.php")
        </script>
        <?php

    }else{
        $admin = $result->fetch_assoc();
        if($admin['type'] != "admin"){
            session_destroy();
            ?>
            <script>
                window.location.replace("login.php")
            </script>
            <?php
        }
    }

}else{
    session_destroy();
    ?>
    <script>
        window.location.replace("login.php")
    </script>
    <?php
}

?>