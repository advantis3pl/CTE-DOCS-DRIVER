function closePopUp(){

    const popUpContainer1 = document.getElementById("popUpCon");
    popUpContainer1.style.display = "none";

    const popUpContainer2 = document.getElementById("sdnPopUp");
    popUpContainer2.style.display = "none";

    const popUpContainer3 = document.getElementById("holdPopUp");
    popUpContainer3.style.display = "none";

    const popUpContainer4 = document.getElementById("removePopUp");
    popUpContainer4.style.display = "none";

}


function closeUserPopUp(){
    const popUpContainer5 = document.getElementById("addUserPopUp");
    popUpContainer5.style.display = "none";
    document.getElementById("auFormError").innerText = "";
}

