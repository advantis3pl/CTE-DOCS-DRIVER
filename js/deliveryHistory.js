const dhError = document.getElementById("dHSearchError");


//input fields (readonly)
const stpCode = document.getElementById("dhStpCode");
const dhCustomerName = document.getElementById("dhCustomerName");
const dhStatus = document.getElementById("dhStatus");
const dhScanStatus = document.getElementById("dhScanStatus");
const dhRemark = document.getElementById("dhRemark");

const dhActionTable = document.getElementById("dhActionTable");
const actionHeader = `<thead><tr><th>Action</th><th>Date/Time</th><th>User</th><th>Remarks</th></tr></thead><tbody>`;
const actionFooter = `</tbody></table>`;

const searchDHButton = document.getElementById("searchDHButton");

//setting the focus on page load
document.getElementById("dhScanDeliveryInput").focus();


$('#dhScanDeliveryInput').keyup(function(){
    if(this.value.length == 10){
        $('#searchDHButton').click();
    }
});
document.getElementById('dHSearchForm').addEventListener('submit', function (event) {
    event.preventDefault();
    dhSearchDelivery();
});

function dhSearchDelivery(){
    dhError.innerText = "";
    let deliveryNumber = document.getElementById("dhScanDeliveryInput").value;
    if(deliveryNumber != ""){
        loadDeliveryData(deliveryNumber);
    }else{
        dhError.innerText = "Delivery No. cannot be empty!";
    }
}

var lastScannedValue = "";
var scanDeliveryNoElement = document.getElementById("dhScanDeliveryInput");
scanDeliveryNoElement.addEventListener("input", function() {

    var updatedValueCount = scanDeliveryNoElement.value.length - lastScannedValue.length; 

    lastScannedValue = scanDeliveryNoElement.value;

    dhError.innerText = "";

    if(updatedValueCount > 1){
        loadDeliveryData(lastScannedValue);
        lastScannedValue = "";
    }

});

function loadDeliveryData(dnNum){

    startDHLoading("On");
    stpCode.value = "";
    dhCustomerName.value = "";
    dhStatus.value = "";
    dhScanStatus.value = "";
    dhRemark.value = "";

    dhActionTable.innerHTML = `${actionHeader} ${actionFooter}`;

    dhError.innerText = "";

    var xhr2 = new XMLHttpRequest();
    xhr2.open("POST", "backend/deliveryHistory/getDeliveryHistory.php", true);
    xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr2.onreadystatechange = function () {
        if (xhr2.readyState === 4) {
            if (xhr2.status === 200) {
                let res2 = xhr2.responseText.toString();
                let jsonRes = JSON.parse(res2);

                startDHLoading("Off");
                if(jsonRes.requestStatus == 200){

                    if(jsonRes.actionCount > 0){
                        let actions = JSON.parse(jsonRes.actions);
                        let finalHtml = "";
                        for(var i = 0; i < actions.length; i++){
                            finalHtml = `${finalHtml} 
                            <tr>
                                <td>${actions[i]['action']}</td>
                                <td>${actions[i]['action_date']} / ${actions[i]['action_time']}</td>
                                <td>${actions[i]['user']}</td>
                                <td>${actions[i]['remark']}</td>
                            </tr>`;

                            if(actions.length == i +1){
                                dhActionTable.innerHTML = `${actionHeader} ${finalHtml} ${actionFooter}`;
                            }
                        }

                        stpCode.value = jsonRes.stpCode;
                        dhCustomerName.value = jsonRes.stpName;
                        dhStatus.value = jsonRes.status;
                        dhScanStatus.value = jsonRes.scanStatus;
                        dhRemark.value = jsonRes.remark;

                    }else{
                        dhActionTable.innerHTML = `${actionHeader} ${actionFooter}`;
                        stpCode.value = jsonRes.stpCode;
                        dhCustomerName.value = jsonRes.stpName;
                        dhStatus.value = jsonRes.status;
                        dhScanStatus.value = jsonRes.scanStatus;
                        dhRemark.value = jsonRes.remark;
                    }

                }else{
                    startDHLoading("Off");
                    dhError.innerText = "Something went wrong!";
                    dhActionTable.innerHTML = `${actionHeader} ${actionFooter}`;
                }

            } else {
                startDHLoading("Off");
                dhError.innerText = "Something went wrong!";
                dhActionTable.innerHTML = `${actionHeader} ${actionFooter}`;
            }
        }
    };

    const data2 = {
        deliveryNumber: dnNum
    };

    var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
    xhr2.send(formData2);
}

function selectText(elementId) {
    var inputField = document.getElementById(elementId);
    inputField.select();
    inputField.setSelectionRange(0, inputField.value.length);
}


function startDHLoading(id){
    if(id == "On"){

        searchDHButton.disabled = true;
        searchDHButton.innerHTML = `<img src="images/loader.gif" alt="" width="15" height="15">`;

    }else{

        searchDHButton.disabled = false;
        searchDHButton.innerHTML = `Search`;

    }
}