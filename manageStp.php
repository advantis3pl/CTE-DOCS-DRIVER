<?php

include("partials/navbar.php");

?>


<p class="border-bottom p-2">Manage STP</p>


<div class="manageStpCon">
    
    <div class="shiptopartyInfo">
        <div class="rasTopBar">
            <h6>Ship - to - Party Info</h6>
            <i class="bx:down-arrow text-white"></i>
        </div>

        <div class="shiptopartyContainer">
            <table>
                <tr>
                    <td class="d-flex">Code <p class="text-danger">&nbsp *</p></td>
                    <td><input type="text" id="clientCode" name="clientCode"></td>
                    <td id="searchBtnCon"><Button class="btn btn-secondary" onclick="searchClient()">Search</Button></td>
                </tr>
                <tr>
                    <td class="d-flex">Name <p class="text-danger">&nbsp *</p></td>
                    <td colspan="2"><input type="text" id="clientName" name="clientName"></td>
                </tr>
                <tr>
                    <td class="d-flex">City <p class="text-danger">&nbsp *</p></td>
                    <td colspan="2"><input type="text" id="clientCity" name="clientCity"></td>
                </tr>
                <tr>
                    <td class="d-flex">Address</td>
                    <td colspan="2"><input type="text" id="clientAddress" name="clientAddress"></td>
                </tr>
                <tr>
                    <td class="d-flex">Zone/Route <p class="text-danger">&nbsp *</p></td>
                    <td colspan="2"><!--<input type="number" id="clientRoute" name="clientRoute">-->
                        <select name="clientRoute" id="clientRoute">
                            <option value="none" hidden>Select the route</option>
                            <?php
                            $query = "SELECT * FROM route";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                    
                            while($route = $result->fetch_assoc()){
                                ?>
                                <option value="<?php echo $route['id']; ?>"><?php echo $route['id']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="d-flex">Status<p class="text-danger">&nbsp *</p></td>
                    <td colspan="2">
                        <select name="clientStatus" id="clientStatus">
                            <option value="none" hidden>Select the status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="d-flex">Main Route (RAS)</td>
                    <td colspan="2"><input type="text" id="mainRouteNumber" name="mainRouteNumber" readonly></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p class="text-danger text-right" id="shiptopartyFormError"></p>
                        <p class="text-success text-right" id="shiptopartyFormSuccess"></p>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <div class="border-top justify-content-around align-items-center d-flex mt-3 pt-2">
                            <input type="text" hidden name="clientDBId" id="clientDBId">
                            <input type="text" hidden name="currentCode" id="currentCode">
                            <button class="btn btn-primary" onclick="saveClient()">Save</button>
                            <button class="btn btn-secondary" onclick="updateClient()">Update</button>
                            <button class="btn btn-secondary" onclick="resetShipToPartyForm()">Reset</button>
                            <button class="btn btn-secondary">View List</button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</div>


<?php

include("partials/footer.php");

?>