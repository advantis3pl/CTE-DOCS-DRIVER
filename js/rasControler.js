const pendingDefualt = `<table><tr><td class="font-bold border text-center p-1">Delivery No.</td><td class="font-bold border text-center p-1">STP Code</td>
<td class="font-bold border text-center p-1">Customer Name</td><td class="font-bold border text-center p-1">Date</td>
<td class="font-bold border text-center p-1">Created By</td><td class="font-bold border text-center p-1">Remove</td></tr></table>`;
const assignedDefualt = `<table><tr><td class="font-bold border text-center p-1">Delivery No.</td><td class="font-bold border text-center p-1">STP Code</td>
<td class="font-bold border text-center p-1">Customer Name</td><td class="font-bold border text-center p-1">Date</td>
<td class="font-bold border text-center p-1">Created By</td><td class="font-bold border text-center p-1">Remove</td></tr></table>`;

unableRASButtons();


function routeClick(id, div) {
    const bars = document.querySelectorAll('.routeBarRow');
    const selectedInput = document.getElementById('selectedRoute');
  
    bars.forEach(bar => {
      bar.style.background = 'white';
      bar.style.transition = 'background 0.2s ease'; 
    });
  
    const clickedBar = document.getElementById(div);
    clickedBar.style.background = '#a9a9a9';
    clickedBar.style.transition = 'background 0.2s ease';
    selectedInput.value = id;
    updateRoute(id);
}


function updateRoute(id){
    document.getElementById("assignedDelError").innerText = ``;
    document.getElementById("pendingDError").innerText = ``
    document.getElementById("pendingDataLoader").innerHTML = ``;
    document.getElementById("assignedDelDataCon").innerHTML = ``;
    document.getElementById("vehicleNumber").innerHTML = ``;

    unableRASButtons();
    loadPending(id);
    loadDrivers(id);
    document.getElementById("loadedRouteNumber").value = id;
}


//pending  
function loadPending(id){
    const pendingDataLoader = document.getElementById("pendingDataLoader");
    const pendingDError = document.getElementById("pendingDError");
    pendingDataLoader.innerHTML = pendingDefualt;
    turnOnPendingDeliveryLoader("on");

    var xhr2 = new XMLHttpRequest();
    xhr2.open("POST", "backend/ras/getRasPending.php", true);
    xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr2.onreadystatechange = function () {
        if (xhr2.readyState === 4) {
            if (xhr2.status === 200) {
                let res2 = xhr2.responseText.toString();
                pendingDataLoader.innerHTML = res2;
                turnOnPendingDeliveryLoader("off");
            } else {
                pendingDError.innerText = `Something went wrong!`;
                turnOnPendingDeliveryLoader("off");
            }
        }
    };

    const data2 = {
        selectedRoute: id,
    };

    var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
    xhr2.send(formData2);
}

//assigned
function loadDrivers(id){

    const vehicleNumbers = document.getElementById("vehicleNumber");
    const assignedDelError = document.getElementById("assignedDelError");

    turnOnAssignedDeliveryLoader("on");

    var xhr2 = new XMLHttpRequest();
    xhr2.open("POST", "backend/ras/getVehicles.php", true);
    xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr2.onreadystatechange = function () {
        if (xhr2.readyState === 4) {
            if (xhr2.status === 200) {
                let res2 = xhr2.responseText.toString()
                vehicleNumbers.innerHTML = res2;
                turnOnAssignedDeliveryLoader("off");
                ableVehicleSettings();
            } else {
                console.log("error");
                turnOnAssignedDeliveryLoader("off");
                assignedDelError.innerText = `Something went wrong. Failed to load drivers`;
            }
        }
    };
    const data2 = {
        selectedRoute: id,
    };
    var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
    xhr2.send(formData2);
}
function assignedDeliveryUpdate(){
    disableVehicleSettings();
    disableAssignedActions();
    turnOnAssignedDeliveryLoader("on");
    const assignedDelDataCon = document.getElementById("assignedDelDataCon");
    const driver = document.getElementById("vehicleNumber").value;
    const assignedDelError = document.getElementById("assignedDelError");

    if(driver != "none"){
        var xhr2 = new XMLHttpRequest();
        xhr2.open("POST", "backend/ras/getRasAssigned.php", true);
        xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr2.onreadystatechange = function () {
            if (xhr2.readyState === 4) {
                if (xhr2.status === 200) {
                    let res2 = xhr2.responseText.toString()
                    assignedDelDataCon.innerHTML = res2;
                    turnOnAssignedDeliveryLoader("off");
                    ableVehicleSettings();
                    ableassignedactions();
                } else {
                    console.log("error");
                    turnOnAssignedDeliveryLoader("off");
                    ableVehicleSettings();
                    assignedDelError.innerText = `Something went wrong. Failed to load drivers`;
                }
            }
        };
        const data2 = {
            driverId: driver,
        };
        var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
        xhr2.send(formData2);
    }else{
        turnOnAssignedDeliveryLoader("off");
        assignedDelDataCon.innerHTML = assignedDefualt;
        ableVehicleSettings();
    }

}

//add driver
function saveDriverDetails(){
    const nic = document.getElementById("driverNIC").value;
    const name = document.getElementById("driverName").value;
    const phone = document.getElementById("driverPhone").value;
    const vehicle = document.getElementById("vehicleN").value;
    const boxes = document.getElementById("no_boxes").value;
    const parcel = document.getElementById("driverParcels").value;
    const sheet = document.getElementById("driverSheet").value;
    const selectedInput = document.getElementById('selectedRoute').value;

    const addDriverError = document.getElementById("addDriverError");
    addDriverError.innerText = ``;

    if(nic != "" && name != "" && phone != "" && vehicle != ""){
        
        let driverValidation = validateDriver(nic,name,phone,vehicle,boxes,parcel,sheet);
        
        if(driverValidation == "done"){

            var xhr2 = new XMLHttpRequest();
            xhr2.open("POST", "backend/ras/addVehicle.php", true);
            xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr2.onreadystatechange = function () {
                if (xhr2.readyState === 4) {
                    if (xhr2.status === 200) {
                        let res2 = xhr2.responseText.toString();
                        let jsonRes = JSON.parse(res2);
                        if(jsonRes.requestStatus == 200){
                            alert(jsonRes.message);
                            loadDrivers(selectedInput);
                            closePopUp();
                        }else{
                            addDriverError.innerText = jsonRes.message;
                        }
                    } else {
                        addDriverError.innerText = "Something went wrong!";
                    }
                }
            };

            const data2 = {
                route: selectedInput,
                nic : nic, 
                name : name,
                phone : phone,
                vehicle : vehicle,
                box : boxes,
                parcel : parcel,
                log : sheet,
            };

            var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
            xhr2.send(formData2);

            
        }else{
            addDriverError.innerText = driverValidation;
            console.log("Data validate error!");
        }

    }else{
        addDriverError.innerText = "Some important fields are empty!";
    }
}
function validateDriver(nic,name,phone,vehicle,boxes,parcel,sheet){

    if (nic.length > 12) {
        return "Invalid NIC number";
    }
    if (isNaN(phone) || phone.length != 10) {
        return "Invalid phone number";
    }
    if (vehicle.length > 10) {
        return "Invalid vehicle number";
    }
    if (isNaN(boxes) || isNaN(parcel)) {
        return "Boxes and parcels should be numbers";
    }
    return "done";
}


//common
function unableRASButtons(){
    document.getElementById("vehicleNumber").disabled = true;
    document.getElementById("addVehicleButton").disabled = true;
    document.getElementById("PrintDNButton").disabled = true;
    document.getElementById("viewDeliveryButton").disabled = true;
    document.getElementById("scanDNButton").disabled = true;
}
function turnOnAssignedDeliveryLoader(status){
    const adLoader = document.getElementById("assignedDeliveryLoader");
    if(status == "on"){
        adLoader.innerHTML = `<img src="images/loader.gif" width="20" height="20" alt="" >`;
    }else{
        adLoader.innerHTML = ``;
    }
}
function turnOnPendingDeliveryLoader(status){
    const pdLoader = document.getElementById("pendingDelLoader");
    if(status == "on"){
        pdLoader.innerHTML = `<img src="images/loader.gif" width="20" height="20" alt="" >`;
    }else{
        pdLoader.innerHTML = ``;
    }
}
function ableVehicleSettings(){
    document.getElementById("vehicleNumber").disabled = false;
    document.getElementById("addVehicleButton").disabled = false;
}
function disableVehicleSettings(){
    document.getElementById("vehicleNumber").disabled = true;
    document.getElementById("addVehicleButton").disabled = true;
}
function disableAssignedActions(){
    document.getElementById("PrintDNButton").disabled = true;
    document.getElementById("viewDeliveryButton").disabled = true;
    document.getElementById("scanDNButton").disabled = true;
}
function ableassignedactions(){
    document.getElementById("PrintDNButton").disabled = false;
    document.getElementById("viewDeliveryButton").disabled = false;
    document.getElementById("scanDNButton").disabled = false;
}


//scan delivery note
var lastScannedValue = "";
var scanDeliveryNoElement = document.getElementById("scanDeliveryNo");
scanDeliveryNoElement.addEventListener("input", function() {
    
    var selectedRoute = document.getElementById("selectedRoute");

    var updatedValueCount = scanDeliveryNoElement.value.length - lastScannedValue.length; 

    lastScannedValue = scanDeliveryNoElement.value;

    const scanDNError = document.getElementById("scanDNError");
    const driver = document.getElementById("vehicleNumber").value;

    scanDNError.innerText = "";

    if(updatedValueCount > 1){

        startScanDNLoading();

        var xhr2 = new XMLHttpRequest();
        xhr2.open("POST", "backend/ras/assignDN.php", true);
        xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr2.onreadystatechange = function () {
            if (xhr2.readyState === 4) {
                if (xhr2.status === 200) {
                    let res2 = xhr2.responseText.toString();
                    let jsonRes = JSON.parse(res2);
                    if(jsonRes.requestStatus == 200){
                        closePopUp();
                        lastScannedValue = "";

                        loadPending(selectedRoute.value);
                        assignedDeliveryUpdate();
                        stopScanDNLoading();

                    }else{
                        scanDNError.innerText = jsonRes.message;
                        stopScanDNLoading();
                    }
                } else {
                    scanDNError.innerText = "Something went wrong!";
                    stopScanDNLoading();
                }
            }
        };

        const data2 = {
            deliveryNumber: scanDeliveryNoElement.value,
            selectedRoute: selectedRoute.value,
            driver: driver
        };

        var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
        xhr2.send(formData2);

    }else{
        //typing
    }

});


function assignSDN(){
    const dn = document.getElementById("scanDeliveryNo");
    const stp = document.getElementById("scanSTPcode");
    const cn = document.getElementById("scanCustomerName");
    const scanDNError = document.getElementById("scanDNError");
    scanDNError.innerText = "";

    var selectedRoute = document.getElementById("selectedRoute");
    const driver = document.getElementById("vehicleNumber").value;

    if(dn.value == ""){
        scanDNError.innerText = "Delivery number cannot be empty!";
    }else{

        startScanDNLoading();

        var xhr2 = new XMLHttpRequest();
        xhr2.open("POST", "backend/ras/assignDN.php", true);
        xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr2.onreadystatechange = function () {
            if (xhr2.readyState === 4) {
                if (xhr2.status === 200) {
                    let res2 = xhr2.responseText.toString();
                    let jsonRes = JSON.parse(res2);
                    if(jsonRes.requestStatus == 200){
                        closePopUp();
                        lastScannedValue = "";

                        loadPending(selectedRoute.value);
                        assignedDeliveryUpdate();
                        stopScanDNLoading();

                    }else{
                        scanDNError.innerText = jsonRes.message;
                        stopScanDNLoading();
                    }
                } else {
                    scanDNError.innerText = "Something went wrong!";
                    stopScanDNLoading();
                }
            }
        };

        const data2 = {
            deliveryNumber: dn.value,
            selectedRoute: selectedRoute.value,
            driver: driver
        };

        var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
        xhr2.send(formData2);

    }

}


function startScanDNLoading(){
    const dn = document.getElementById("scanDeliveryNo");
    const stp = document.getElementById("scanSTPcode");
    const cn = document.getElementById("scanCustomerName");
    const cross = document.getElementById("scanDNCross");
    const close = document.getElementById("scanDNCloseButton");
    const assign = document.getElementById("scanDNAssignButton");

    dn.disabled = true;
    stp.disabled = true;
    cn.disabled = true;
    cross.disabled = true;
    close.disabled = true;
    assign.disabled = true;

    document.getElementById("scanDNLoadingImg").classList.remove("d-none");
    document.getElementById("scanDNLoadingImg").classList.add("d-block");

}

function stopScanDNLoading(){
    const dn = document.getElementById("scanDeliveryNo");
    const stp = document.getElementById("scanSTPcode");
    const cn = document.getElementById("scanCustomerName");
    const cross = document.getElementById("scanDNCross");
    const close = document.getElementById("scanDNCloseButton");
    const assign = document.getElementById("scanDNAssignButton");

    dn.disabled = false;
    stp.disabled = false;
    cn.disabled = false;
    cross.disabled = false;
    close.disabled = false;
    assign.disabled = false;

    document.getElementById("scanDNLoadingImg").classList.remove("d-block");
    document.getElementById("scanDNLoadingImg").classList.add("d-none");
}