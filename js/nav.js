function navOpCl(){
    const isNavOpen = document.getElementById("isNavOpen");
    const sidebar = document.getElementById("sidebar");
    const mainContainer = document.getElementById("mainContainer");
    const navButton = document.getElementById("navButton");

    const navFormButton = document.getElementById("setNavBarSession");

    if(isNavOpen.value == "0"){
        //open
        sidebar.classList.remove("navClose");
        sidebar.classList.add("navOpen");
        mainContainer.classList.remove("deactive-cont");
        mainContainer.classList.add("active-cont");
        navButton.innerText = "<";
        isNavOpen.value = "1";
        sendNabBarRequest(1);
    }else{
        //close
        sidebar.classList.remove("navOpen");
        sidebar.classList.add("navClose");
        mainContainer.classList.remove("active-cont");
        mainContainer.classList.add("deactive-cont");
        navButton.innerText = ">";
        isNavOpen.value = "0";
        sendNabBarRequest(0);
    }
}

function sendNabBarRequest(status){
    var xhr2 = new XMLHttpRequest();
    xhr2.open("POST", "backend/navbar/changeStatus.php", true);
    xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr2.onreadystatechange = function () {};
    const data2 = {
        navBarStatus: status
    };
    var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
    xhr2.send(formData2);
}