function addVehicle(){
    const popUpContainer = document.getElementById("popUpCon");
    const popUpWindow = document.getElementById("popUpWindow");
    popUpContainer.style.display = "block";
}

function turnOnScan() {
    const popUpContainer = document.getElementById("sdnPopUp");
    popUpContainer.style.display = "block";
    const scanDeliveryNoInput = document.getElementById("scanDeliveryNo");
    if (scanDeliveryNoInput) {
        scanDeliveryNoInput.focus();
    }
}


function turnOnHold(id,delivery,remark){
    const popUpContainer = document.getElementById("holdPopUp");
    popUpContainer.style.display = "block";
    document.getElementById("hDnSelectedDelivery").value = id;
    document.getElementById("hDnDeliveryNumber").value = delivery;
    document.getElementById("hDNRemark").value = remark;
}

function removeOn(id,delivery,remark){
    const popUpContainer = document.getElementById("removePopUp");
    popUpContainer.style.display = "block";

    document.getElementById("selectedIdForRemove").value = id;
    document.getElementById("rDnDeliveryNo").value = delivery;
    document.getElementById("rDNRemark").value = remark;
}

