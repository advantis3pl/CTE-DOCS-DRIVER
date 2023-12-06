function addVehicle(){
    const popUpContainer = document.getElementById("popUpCon");
    const popUpWindow = document.getElementById("popUpWindow");
    popUpContainer.style.display = "block";
}

function turnOnScan(){
    const popUpContainer = document.getElementById("sdnPopUp");
    popUpContainer.style.display = "block";
}

function printAssigned(){
    alert('print assigned deliveries');
}

function turnOnHold(){
    const popUpContainer = document.getElementById("holdPopUp");
    popUpContainer.style.display = "block";
}

function removeOn(){
    const popUpContainer = document.getElementById("removePopUp");
    popUpContainer.style.display = "block";
}