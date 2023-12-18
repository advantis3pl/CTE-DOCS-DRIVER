//scan delivery number
var lastScannedValue = "";
var scanDeliveryNo = document.getElementById("deliveryNumberInput");
scanDeliveryNo.addEventListener("input", function() {

    var updatedValueCount = scanDeliveryNo.value.length - lastScannedValue.length; 

    lastScannedValue = scanDeliveryNo.value;

    const scanDNError = document.getElementById("scanDNErrorUP");

    scanDNError.innerText = "";

    if(updatedValueCount > 1){

        addDelivery(lastScannedValue);

    }

});

// 0-deliveryNum 1-stpCode 2-customerName 3-remark
const pendingDeliveries = [];


function addDelivery(scannedValue){

    document.getElementById("updateError").innerText = "";
    document.getElementById("updateSuccess").innerText = "";

    const scanDNError = document.getElementById("scanDNErrorUP");
    scanDNError.innerText = "";

    var scannedFalg = false; 
    for(var i = 0; i < pendingDeliveries.length; i++){
        if(pendingDeliveries[i][0] == scannedValue){
            scannedFalg = true; 
            break; 
        }
    }

    if(!scannedFalg){
        startLoadingUDN();
        var scanDeliveryNo = document.getElementById("deliveryNumberInput");
        var xhr2 = new XMLHttpRequest();
        xhr2.open("POST", "backend/updatePending/validateDN.php", true);
        xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr2.onreadystatechange = function () {
            if (xhr2.readyState === 4) {
                if (xhr2.status === 200) {
                    let res2 = xhr2.responseText.toString();
                    let jsonRes = JSON.parse(res2);
                    if(jsonRes.requestStatus == 200){
                        
                        //success
                        //add to an array
                        //call refresh table function 
                        lastScannedValue = "";
                        scanDeliveryNo.value = "";
                        pendingDeliveries.push([jsonRes.dn , jsonRes.stpCode , jsonRes.stpName , jsonRes.remark]);
                        stopLoadingDN();
                        refreshPendingDeliveries();
    
                    }else{
                        scanDNError.innerText = jsonRes.message;
                        stopLoadingDN();
                    }
                } else {
                    scanDNError.innerText = "Something went wrong!";
                    stopLoadingDN();
                }
            }
        };
    
        const data2 = {
            deliveryNumber: scannedValue
        };
    
        var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
        xhr2.send(formData2);

    }else{
        scanDNError.innerText = "Already added!";
    }
}

function startLoadingUDN(){
    document.getElementById("scanDNErrorUP").innerText = "";
    document.getElementById("addButtonUDN").innerHTML = `<img src="images/loader.gif" alt="" width="20" height="20">`;
    document.getElementById("addButtonUDN").disabled = true;
    document.getElementById("deliveryNumberInput").disabled = true;
}

function stopLoadingDN(){
    document.getElementById("addButtonUDN").innerHTML = `Add`;
    document.getElementById("addButtonUDN").disabled = false;
    document.getElementById("deliveryNumberInput").disabled = false;
}


function addDeliveryNoByButton(){
    var enteredVal = document.getElementById("deliveryNumberInput").value;
    if(enteredVal != ""){
        addDelivery(enteredVal);
    }
}


function refreshPendingDeliveries(){
    const list = document.getElementById("pendingAddedList");
    
    var finalHtml = `
    <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="border border-dark">Delivery No.</th>
                                    <th class="border border-dark">STP Code</th>
                                    <th class="border border-dark">Customer Name</th>
                                    <th class="border border-dark">Remark</th>
                                    <th class="border border-dark">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
    `;
    var closingHtml = `</tbody>
    </table>`;

    if(pendingDeliveries.length > 0){

        for(var i = 0; i < pendingDeliveries.length; i++){

            var currentHtml = `
            
            <tr>
                <td class="border border-dark">${pendingDeliveries[i][0]}</td>
                <td class="border border-dark">${pendingDeliveries[i][1]}</td>
                <td class="border border-dark">${pendingDeliveries[i][2]}</td>
                <td class="border border-dark">
                    <input type="text" name="addedRemark${i}" id="addedRemark${i}" value="${pendingDeliveries[i][3]}" class="form-control">
                </td>
                <td class="border border-dark">
                    <button class="btn btn-danger" onclick="removeFromAddedList(${i})">X</button>
                </td>
            </tr>

            `;


            finalHtml = `${finalHtml} ${currentHtml}`;

        }

    }

    finalHtml = `${finalHtml} ${closingHtml}`;
    list.innerHTML = finalHtml;

}


function removeFromAddedList(id) {
    if (Array.isArray(pendingDeliveries) && id >= 0 && id < pendingDeliveries.length) {
        pendingDeliveries.splice(id, 1);
        refreshPendingDeliveries();
    }
}

function clearAllAdded(){
    pendingDeliveries.length = 0;
    refreshPendingDeliveries();
}


function updatePending(id){
    
    const updateError = document.getElementById("updateError");
    const updateSuccess = document.getElementById("updateSuccess");

    updateError.innerText = "";
    updateSuccess.innerText = "";

    if(pendingDeliveries.length != 0){

        let remarkAll = document.getElementById("remarkAll");
        
        for(var i = 0; i < pendingDeliveries.length; i++){

            let addedRemark = document.getElementById(`addedRemark${i}`).value;

            if(addedRemark == ""){
                addedRemark = remarkAll.value;
            }

            pendingDeliveries[i][3] = addedRemark;

        }

        startUpdateLoading();

        var xhr2 = new XMLHttpRequest();
        xhr2.open("POST", "backend/updatePending/updatePendingDeliveries.php", true);
        xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr2.onreadystatechange = function () {
            if (xhr2.readyState === 4) {
                if (xhr2.status === 200) {
                    let res2 = xhr2.responseText.toString();
                    let jsonRes = JSON.parse(res2);
                    if(jsonRes.requestStatus == 200){

                        updateError.innerText = "";
                        updateSuccess.innerText = "Deliveries Updated Successfully!";
                        clearAllAdded();
                        document.getElementById("remarkAll").value = "";
                        stopUpdateLoading();

    
                    }else if(jsonRes.requestStatus == 400){
                        updateError.innerText = jsonRes.message;
                        stopUpdateLoading();
                    }else{
                        updateError.innerText = jsonRes.message;
                        stopUpdateLoading();
                    }
                } else {
                    updateError.innerText = "Something went wrong!";
                    stopUpdateLoading();
                }
            }
        };
    
        const data2 = {
            type: id,
            deliveries: JSON.stringify(pendingDeliveries)
        };
    
        var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
        xhr2.send(formData2);


    }else{
        alert("No deliveries were added!");
    }

}

function startUpdateLoading(){
    document.getElementById("addButtonUDN").innerHTML = `<img src="images/loader.gif" alt="" width="20" height="20">`;
    document.getElementById("addButtonUDN").disabled = true;
    document.getElementById("deliveryNumberInput").disabled = true;
    document.getElementById("clearAllButton").disabled = true;
    document.getElementById("remarkAll").disabled = true;
    document.getElementById("invoiceButton").disabled = true;
    document.getElementById("specialDNButton").disabled = true;
    document.getElementById("CustomerCButton").disabled = true;
    document.getElementById("pendingAddedList").style.pointerEvents = "none";
}

function stopUpdateLoading(){
    document.getElementById("addButtonUDN").innerHTML = `Add`;
    document.getElementById("addButtonUDN").disabled = false;
    document.getElementById("deliveryNumberInput").disabled = false;
    document.getElementById("clearAllButton").disabled = false;
    document.getElementById("remarkAll").disabled = false;
    document.getElementById("invoiceButton").disabled = false;
    document.getElementById("specialDNButton").disabled = false;
    document.getElementById("CustomerCButton").disabled = false;
    document.getElementById("pendingAddedList").style.pointerEvents = "auto";
}