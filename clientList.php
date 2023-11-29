<?php

include("partials/navbar.php");

?>


<div class="justify-content-between align-items-center d-flex border-bottom p-2">
    <p>Client List</p>
    <button class="btn btn-primary" onclick="downloadPDF()">PDF</button>
</div>

<div class="p-4" id="clientListCon">
    <h1 class="font-bold underline text-center">Ship To Party Report</h1>
    <table class="table">
        <tr>
            <td class="text-center font-bold">Route</td>
            <td class="text-center font-bold">Code</td>
            <td class="text-center font-bold">Name</td>
            <td class="text-center font-bold">City</td>
            <td class="text-center font-bold">Address</td>
            <td class="text-center font-bold">Status</td>
        </tr>

        <?php
        
        $query = "SELECT * FROM client";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        while($client = $result->fetch_assoc()){
            ?>
            <tr>
                <td class="text-center"><?php echo $client['route'];?></td>
                <td class="text-center"><?php echo $client['code'];?></td>
                <td class="text-center"><?php echo $client['name'];?></td>
                <td class="text-center"><?php echo $client['city'];?></td>
                <td class="text-center"><?php echo $client['address'];?></td>
                <td class="text-center"><?php echo $client['status'];?></td>
            </tr>
            <?php
        }
        
        ?>
    </table>
</div>

<?php

include("partials/footer.php");

?>