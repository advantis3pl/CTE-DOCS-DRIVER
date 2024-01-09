var vehicles = [];
var assigned = [];
var returnArray = [];

var assignedHeader = `<table><tr>
<td class="font-bold border text-center p-1">Vehicle</td>
<td class="font-bold border text-center p-1">Driver</td>
<td class="font-bold border text-center p-1">NIC</td>
<td class="font-bold border text-center p-1">No. Boxes</td>
<td class="font-bold border text-center p-1">No. Parcels</td>
<td class="font-bold border text-center p-1">Log Sheet</td>
<td class="font-bold border text-center p-1">Dispatch Time</td></tr>`;
var assignedFooter = `</table>`;
var assignedTableTop = `<table><tr>
    <td class="font-bold border text-center p-1">Delivery No</td>
    <td class="font-bold border text-center p-1">STP Code</td>
    <td class="font-bold border text-center p-1">Customer Name</td>
    <td class="font-bold border text-center p-1">Ack Status</td>
</tr>`;
var returnTableTop = `<table><tr>
    <td class="font-bold border text-center p-1">Delivery No</td>
    <td class="font-bold border text-center p-1">STP Code</td>
    <td class="font-bold border text-center p-1">Customer Name</td>
    <td class="font-bold border text-center p-1">Type</td>
</tr>`;

document.getElementById("NDButton").disabled = true;
document.getElementById("SDRButton").disabled = true;

const currentDate = new Date();
const year = currentDate.getFullYear();
let month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
let day = currentDate.getDate().toString().padStart(2, '0');
const formattedDate = `${year}-${month}-${day}`;
document.getElementById('rrDateInput').value = formattedDate;

//calling the searching function on page load
getDataBySearch();


function rrSelectRoute(route, element) {

    document.getElementById("rrSelectedRoute").value = "";
    document.getElementById("selectedVehicleId").value = "";
    document.getElementById("selectedDeliveryId").value = "";
    document.getElementById("selectedDeliveryNumber").value = "";

    var routeBars = document.getElementsByClassName("routeTableBar");
    //turn off buttons 

    for (var i = 0; i < routeBars.length; i++) {
        routeBars[i].style.background = "white";
    }
    document.getElementById(element).style.background = "gray";
    document.getElementById("rrSelectedRoute").value = route;

    const rrAssignedDeliveryContainer = document.getElementById("rrAssignedDeliveryContainer");
    rrAssignedDeliveryContainer.innerHTML = `${assignedTableTop}${assignedFooter}`;
    const rrReturnDeliveryContainer = document.getElementById("rrReturnDeliveryContainer");
    rrReturnDeliveryContainer.innerHTML = `${returnTableTop}${assignedFooter}`;
    

    document.getElementById("NDButton").disabled = true;
    document.getElementById("SDRButton").disabled = true;
    getRoutePlan(route);
    
}


function clearAllSelected(){
    var routeBars = document.getElementsByClassName("routeTableBar");
    for (var i = 0; i < routeBars.length; i++) {
        routeBars[i].style.background = "white";
    }
}


function getRoutePlan(route){
    var filteredVehicles = [];
    let assignedBody = ``;

    const rrRouteVehicleContainer = document.getElementById("rrRouteVehicleContainer");
    rrRouteVehicleContainer.innerHTML = ``;

    for(var i = 0; i < vehicles.length; i++){
        if(vehicles[i]['route'] == route){
            filteredVehicles.push(vehicles[i]);
            assignedBody = `${assignedBody} 
            <tr class="routePlanTableElements" onclick="onclickRoutePlan('${vehicles[i]['id']}','routePlanData${vehicles[i]['id']}')" id="routePlanData${vehicles[i]['id']}">
                <td class="border text-center p-1">${vehicles[i]['vehicle']}</td>
                <td class="border text-center p-1">${vehicles[i]['name']}</td>
                <td class="border text-center p-1">${vehicles[i]['nic']}</td>
                <td class="border text-center p-1">${vehicles[i]['no_box']}</td>
                <td class="border text-center p-1">${vehicles[i]['no_parcel']}</td>
                <td class="border text-center p-1">${vehicles[i]['log_no']}</td>
                <td class="border text-center p-1">${vehicles[i]['printedTime']}</td>
            </tr>`;
        }

        if(i + 1 == vehicles.length){
            var finalHtml = `${assignedHeader} ${assignedBody} ${assignedFooter}`;
            rrRouteVehicleContainer.innerHTML = finalHtml;
        }
    }

    if(filteredVehicles.length == 0){
        rrRouteVehicleContainer.innerHTML = `${assignedHeader} 
        <tr><td colspan="7" class="text-secondary text-center pt-2">No records</td></tr>
        ${assignedFooter}`;
    }

}


function getDataBySearch(){

    document.getElementById("rrSelectedRoute").value = "";
    document.getElementById("selectedVehicleId").value = "";
    document.getElementById("selectedDeliveryId").value = "";
    document.getElementById("selectedDeliveryNumber").value = "";

    const date = document.getElementById('rrDateInput').value;
    const routeList = document.getElementById("rrRouteList");
    routeList.style.pointerEvents = "none";
    routeList.style.opacity = .3;

    const rrAssignedDeliveryContainer = document.getElementById("rrAssignedDeliveryContainer");
    rrAssignedDeliveryContainer.innerHTML = `${assignedTableTop}${assignedFooter}`;
    const rrRouteVehicleContainer = document.getElementById("rrRouteVehicleContainer");
    rrRouteVehicleContainer.innerHTML = `${assignedHeader}${assignedFooter}`;
    const rrReturnDeliveryContainer = document.getElementById("rrReturnDeliveryContainer");
    rrReturnDeliveryContainer.innerHTML = `${returnTableTop}${assignedFooter}`;
    clearAllSelected();

    var xhr2 = new XMLHttpRequest();
    xhr2.open("POST", "backend/routeReconciliation/searchDate.php", true);
    xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr2.onreadystatechange = function () {
        if (xhr2.readyState === 4) {
            if (xhr2.status === 200) {
                
                let res2 = xhr2.responseText.toString();
                let jsonRes = JSON.parse(res2);

                if(jsonRes.requestStatus == 200){
                    vehicles = JSON.parse(jsonRes.vehicles);
                    assigned = JSON.parse(jsonRes.assigned);
                    returnArray = JSON.parse(jsonRes.returns);
                    routeList.style.pointerEvents = "auto";
                    routeList.style.opacity = 1;

                    document.getElementById("searchedDateContainer").innerText = `Results for : ${date}`;

                }else{
                    alert("Something went wrong while loading the data!");
                }
                
            } else {
                alert("Something went wrong!");
            }
        }
    };

    const data2 = {
        searchedDate: date
    };

    var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
    xhr2.send(formData2);
}

function onclickRoutePlan(id,element){
    document.getElementById("selectedDeliveryId").value = "";
    document.getElementById("selectedDeliveryNumber").value = "";
    document.getElementById("NDButton").disabled = true;
    document.getElementById("SDRButton").disabled = true;

    var routeBars = document.getElementsByClassName("routePlanTableElements");
    for (var i = 0; i < routeBars.length; i++) {
        routeBars[i].style.background = "white";
    }
    document.getElementById(element).style.background = "#8ea0bd";
    document.getElementById("selectedVehicleId").value = id;
    loadAssignedDeliveries(id);
    loadReturnDeliveries(id);
}

function loadAssignedDeliveries(id){
    var filteredAssigned = [];
    let assignedBody = ``;

    const rrAssignedDeliveryContainer = document.getElementById("rrAssignedDeliveryContainer");
    rrAssignedDeliveryContainer.innerHTML = ``;

    for(var i = 0; i < assigned.length; i++){
        if(assigned[i]['driverId'] == id){
            filteredAssigned.push(assigned[i]);
            assignedBody = `${assignedBody} 
            <tr class="assignedDeliveryElements" onclick="selectAssignedDelivery('${assigned[i]['id']}','${assigned[i]['delivery_no']}','assignedDelivery${assigned[i]['id']}')" id="assignedDelivery${assigned[i]['id']}">
                <td class="border text-center p-1">${assigned[i]['delivery_no']}</td>
                <td class="border text-center p-1">${assigned[i]['stp_code']}</td>
                <td class="border text-center p-1">${assigned[i]['stp_name']}</td>
                <td class="border text-center p-1">${assigned[i]['ack_status']}</td>
            </tr>`;

        }

        if(i+1 == assigned.length){
            var finalHtml = `${assignedTableTop} ${assignedBody} ${assignedFooter}`;
            rrAssignedDeliveryContainer.innerHTML = finalHtml;
        }
    }

    if(filteredAssigned.length == 0){
        rrAssignedDeliveryContainer.innerHTML = `${assignedTableTop} ${assignedFooter}`;
    }

}

//load returns 
function loadReturnDeliveries(id){
    var filteredReturn = [];
    let returnBody = ``;

    const rrReturnDeliveryContainer = document.getElementById("rrReturnDeliveryContainer");
    rrReturnDeliveryContainer.innerHTML = `${returnTableTop} ${assignedFooter}`;

    for(var i = 0; i < returnArray.length; i++){

        var returnType = "Not Delivered DN";
        if(returnArray[i]['type'] == "SDR"){
            returnType = "Same Day Return";
        }

        if(returnArray[i]['vehicle'] == id){
            filteredReturn.push(returnArray[i]);
            returnBody = `${returnBody} <tr>
            <td class="font-bold border text-center p-1">${returnArray[i]['delivery_no']}</td>
            <td class="font-bold border text-center p-1">${returnArray[i]['stp_code']}</td>
            <td class="font-bold border text-center p-1">${returnArray[i]['stp_name']}</td>
            <td class="font-bold border text-center p-1">${returnType}</td>
        </tr>`;
        }

        if(i+1 == returnArray.length){
            var finalHtml = `${returnTableTop} ${returnBody} ${assignedFooter}`;
            rrReturnDeliveryContainer.innerHTML = finalHtml;
        }
    }

    if(filteredReturn.length == 0){
        rrReturnDeliveryContainer.innerHTML = `${returnTableTop} ${assignedFooter}`;
    }

}


function selectAssignedDelivery(id,deliveryNumber,element){
    var routeBars = document.getElementsByClassName("assignedDeliveryElements");
    for (var i = 0; i < routeBars.length; i++) {
        routeBars[i].style.background = "white";
    }
    document.getElementById(element).style.background = "#8ea0bd";
    document.getElementById("selectedDeliveryId").value = id;
    document.getElementById("selectedDeliveryNumber").value = deliveryNumber;
    document.getElementById("NDButton").disabled = false;
    document.getElementById("SDRButton").disabled = false;

}



function notDeliveredDn(){
    const selectedRoute = document.getElementById("rrSelectedRoute");
    const selectedVehicle = document.getElementById("selectedVehicleId");
    const selectedDelivery = document.getElementById("selectedDeliveryId");
    const selectedDeliveryNumber = document.getElementById("selectedDeliveryNumber");

    if(selectedRoute.value == "" || selectedVehicle.value == "" || selectedDelivery.value == "" || selectedDeliveryNumber.value == ""){
        alert("Something went wrong!");
    }else{

        const nddnPopUp = document.getElementById("nddnPopUp");
        nddnPopUp.style.display = "block";
        document.getElementById("nddnDeliveryNumber").value = selectedDeliveryNumber.value;
        document.getElementById("nddnRemark").value = "";
        
    }
}

function sameDayReturnDN(){
    const selectedRoute = document.getElementById("rrSelectedRoute");
    const selectedVehicle = document.getElementById("selectedVehicleId");
    const selectedDelivery = document.getElementById("selectedDeliveryId");
    const selectedDeliveryNumber = document.getElementById("selectedDeliveryNumber");

    if(selectedRoute.value == "" || selectedVehicle.value == "" || selectedDelivery.value == "" || selectedDeliveryNumber.value == ""){
        alert("Something went wrong!");
    }else{
        const sdrPopUp = document.getElementById("sdrPopUp");
        sdrPopUp.style.display = "block";
        document.getElementById("sdrDeliveryNumber").value = selectedDeliveryNumber.value;
        document.getElementById("nddnRemark").value = "";
    }
}

function closeRRPopUp(){
    const nddnPopUp = document.getElementById("nddnPopUp");
    nddnPopUp.style.display = "none";
    document.getElementById("nddnDeliveryNumber").value = "";
    document.getElementById("nddnRemark").value = "";
    document.getElementById("nddnError").innerText = ``;

    const sdrPopUp = document.getElementById("sdrPopUp");
    sdrPopUp.style.display = "none";
    document.getElementById("sdrDeliveryNumber").value = "";
    document.getElementById("sdrRemark").value = "";
    document.getElementById("sdrError").innerText = ``;
}

function UpdateAsNotDeliveredDN(){

    startLoadingND();

    const selectedRoute = document.getElementById("rrSelectedRoute").value;
    const selectedVehicle = document.getElementById("selectedVehicleId").value;
    const selectedDelivery = document.getElementById("selectedDeliveryId").value;
    const selectedDeliveryNumber = document.getElementById("selectedDeliveryNumber").value;
    let remark = document.getElementById("nddnRemark").value;

    const nddnError = document.getElementById("nddnError");
    nddnError.innerText = ``;
    
    if(remark != ""){

        var xhr2 = new XMLHttpRequest();
        xhr2.open("POST", "backend/routeReconciliation/returnUpdate.php", true);
        xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr2.onreadystatechange = function () {
            if (xhr2.readyState === 4) {
                if (xhr2.status === 200) {
                    
                    let res2 = xhr2.responseText.toString();
                    let jsonRes = JSON.parse(res2);
                    
                    if(jsonRes.requestStatus == 200){
                        //success
                        closeRRPopUp();
                        stopLoadingND();
                        refreshLocation(selectedRoute,selectedVehicle,`routePlanData${selectedVehicle}`);


                    }else if(jsonRes.requestStatus == 400){
                        //compeleted with errors
                        stopLoadingND();
                        nddnError.innerText = jsonRes.message;
                    }else{
                        //error
                        stopLoadingND();
                        nddnError.innerText = jsonRes.message;
                    }

                    
                } else {
                    stopLoadingND();
                    nddnError.innerText = `Something went wrong!`;
                }
            }
        };
        const data2 = {
            deliveryId: selectedDelivery,
            deliveryNumber: selectedDeliveryNumber,
            remark: remark,
            type: "ND",
            route: selectedRoute,
            vehicle: selectedVehicle
        };
        var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
        xhr2.send(formData2);

    }else{
        stopLoadingND();
        nddnError.innerText = `Remark cannot be empty!`;
    }
}

function UpdateAsSameDayReturn(){
    startLoadingSDR();
    const selectedRoute = document.getElementById("rrSelectedRoute").value;
    const selectedVehicle = document.getElementById("selectedVehicleId").value;
    const selectedDelivery = document.getElementById("selectedDeliveryId").value;
    const selectedDeliveryNumber = document.getElementById("selectedDeliveryNumber").value;
    let remark = document.getElementById("sdrRemark").value;

    const sdrError = document.getElementById("sdrError");
    sdrError.innerText = ``;

    if(remark != ""){
        var xhr2 = new XMLHttpRequest();
        xhr2.open("POST", "backend/routeReconciliation/returnUpdate.php", true);
        xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr2.onreadystatechange = function () {
            if (xhr2.readyState === 4) {
                if (xhr2.status === 200) {
                    
                    let res2 = xhr2.responseText.toString();
                    let jsonRes = JSON.parse(res2);
                    
                    if(jsonRes.requestStatus == 200){
                        //success
                        refreshLocation(selectedRoute,selectedVehicle,`routePlanData${selectedVehicle}`);
                        closeRRPopUp();
                        stopLoadingSDR();

                    }else if(jsonRes.requestStatus == 400){
                        //compeleted with errors
                        stopLoadingSDR();
                        sdrError.innerText = jsonRes.message;
                    }else{
                        //error
                        stopLoadingSDR();
                        sdrError.innerText = jsonRes.message;
                    }

                    
                } else {
                    stopLoadingSDR();
                    sdrError.innerText = `Something went wrong!`;
                }
            }
        };
        const data2 = {
            deliveryId: selectedDelivery,
            deliveryNumber: selectedDeliveryNumber,
            remark: remark,
            type: "SDR",
            route: selectedRoute,
            vehicle: selectedVehicle
        };
        var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
        xhr2.send(formData2);


    }else{
        stopLoadingSDR();
        sdrError.innerText = `Remark cannot be empty!`;
    }
}


function refreshLocation(route,vehicle,element){

    const date = document.getElementById('rrDateInput').value;
    const routeList = document.getElementById("rrRouteList");
    routeList.style.pointerEvents = "none";
    routeList.style.opacity = .3;

    const rrAssignedDeliveryContainer = document.getElementById("rrAssignedDeliveryContainer");
    rrAssignedDeliveryContainer.innerHTML = `${assignedTableTop}${assignedFooter}`;
    const rrRouteVehicleContainer = document.getElementById("rrRouteVehicleContainer");
    rrRouteVehicleContainer.innerHTML = `${assignedHeader}${assignedFooter}`;

    var xhr2 = new XMLHttpRequest();
    xhr2.open("POST", "backend/routeReconciliation/searchDate.php", true);
    xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr2.onreadystatechange = function () {
        if (xhr2.readyState === 4) {
            if (xhr2.status === 200) {
                
                let res2 = xhr2.responseText.toString();
                let jsonRes = JSON.parse(res2);
                
                if(jsonRes.requestStatus == 200){
                    vehicles = JSON.parse(jsonRes.vehicles);
                    assigned = JSON.parse(jsonRes.assigned);
                    returnArray = JSON.parse(jsonRes.returns);
                    routeList.style.pointerEvents = "auto";
                    routeList.style.opacity = 1;

                    //getting the route plan
                    var filteredVehicles = [];
                    let assignedBody = ``;

                    const rrRouteVehicleContainer = document.getElementById("rrRouteVehicleContainer");
                    rrRouteVehicleContainer.innerHTML = ``;

                    for(var i = 0; i < vehicles.length; i++){
                        if(vehicles[i]['route'] == route){
                            filteredVehicles.push(vehicles[i]);
                            assignedBody = `${assignedBody} 
                            <tr class="routePlanTableElements" onclick="onclickRoutePlan('${vehicles[i]['id']}','routePlanData${vehicles[i]['id']}')" id="routePlanData${vehicles[i]['id']}">
                                <td class="border text-center p-1">${vehicles[i]['vehicle']}</td>
                                <td class="border text-center p-1">${vehicles[i]['name']}</td>
                                <td class="border text-center p-1">${vehicles[i]['nic']}</td>
                                <td class="border text-center p-1">${vehicles[i]['no_box']}</td>
                                <td class="border text-center p-1">${vehicles[i]['no_parcel']}</td>
                                <td class="border text-center p-1">${vehicles[i]['log_no']}</td>
                                <td class="border text-center p-1">${vehicles[i]['printedTime']}</td>
                            </tr>`;
                        }

                        if(i + 1 == vehicles.length){
                            var finalHtml = `${assignedHeader} ${assignedBody} ${assignedFooter}`;
                            rrRouteVehicleContainer.innerHTML = finalHtml;
                            onclickRoutePlan(vehicle,element);
                        }
                    }

                    if(filteredVehicles.length == 0){
                        rrRouteVehicleContainer.innerHTML = `${assignedHeader} 
                        <tr><td colspan="7" class="text-secondary text-center pt-2">No records</td></tr>
                        ${assignedFooter}`;
                    }


                }else{
                    alert("Something went wrong while loading the data!");
                }
                
            } else {
                alert("Something went wrong!");
            }
        }
    };

    const data2 = {
        searchedDate: date
    };

    var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
    xhr2.send(formData2);
}


function startLoadingND(){
    document.getElementById("nddnCross").disabled = true;
    document.getElementById("nddnSubmitBtn").disabled = true;
    document.getElementById("nddnCloseBtn").disabled = true;
}
function stopLoadingND(){
    document.getElementById("nddnCross").disabled = false;
    document.getElementById("nddnSubmitBtn").disabled = false;
    document.getElementById("nddnCloseBtn").disabled = false;
}
function startLoadingSDR(){
    document.getElementById("sdrCross").disabled = true;
    document.getElementById("sdrSubmitButton").disabled = true;
    document.getElementById("sdrCloseBtn").disabled = true;
}
function stopLoadingSDR(){
    document.getElementById("sdrCross").disabled = false;
    document.getElementById("sdrSubmitButton").disabled = false;
    document.getElementById("sdrCloseBtn").disabled = false;
}