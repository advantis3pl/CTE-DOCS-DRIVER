function closePopUp(){

    const popUpContainer1 = document.getElementById("popUpCon");
    popUpContainer1.style.display = "none";

    const popUpContainer2 = document.getElementById("sdnPopUp");
    popUpContainer2.style.display = "none";

    const popUpContainer3 = document.getElementById("holdPopUp");
    popUpContainer3.style.display = "none";

    const popUpContainer4 = document.getElementById("removePopUp");
    popUpContainer4.style.display = "none";

    const popUpContainer5 = document.getElementById("viewDriverInfo");
    popUpContainer5.style.display = "none";

    //add vehicle
    document.getElementById("driverNIC").value = '';
    document.getElementById("driverName").value = '';
    document.getElementById("driverPhone").value = '';
    document.getElementById("vehicleN").value = '';
    document.getElementById("no_boxes").value = '';
    document.getElementById("driverParcels").value = '';
    document.getElementById("driverSheet").value = '';

    //update vehicle
    document.getElementById("driverNIC_info").value = '';
    document.getElementById("driverName_info").value = '';
    document.getElementById("driverPhone_info").value = '';
    document.getElementById("vehicleN_info").value = '';
    document.getElementById("no_boxes_info").value = '';
    document.getElementById("driverParcels_info").value = '';
    document.getElementById("driverSheet_info").value = '';

    //sdn
    document.getElementById("scanDeliveryNo").value = '';
    document.getElementById("scanSTPcode").value = '';
    document.getElementById("scanCustomerName").value = '';

}

function closeUserPopUp(){
    const popUpContainer5 = document.getElementById("addUserPopUp");
    popUpContainer5.style.display = "none";
    document.getElementById("auFormError").innerText = "";
}

