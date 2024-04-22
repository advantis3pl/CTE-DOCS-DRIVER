<?php
include("../userAuth.php");

if(isset($_POST['navBarStatus'])){
    $type = $_POST['navBarStatus'];
    echo $type;
    if($type == 1){
        $_SESSION['setNavBarSession'] = "On";
        echo "Success set";
    }else{
        unset($_SESSION['setNavBarSession']);
        echo "Success unset";
    }
}else{
    echo "access error";
}

?>