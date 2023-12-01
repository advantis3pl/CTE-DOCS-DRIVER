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
    
}
  
