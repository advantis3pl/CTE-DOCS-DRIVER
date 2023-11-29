
<?php

include("partials/navbar.php");

?>

<?php

    session_destroy();
    ?>
    <script>
        window.location.replace("index.php");
    </script>
    <?php

?>

<?php

include("partials/footer.php");

?>