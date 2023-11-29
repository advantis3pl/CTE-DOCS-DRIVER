function navOpCl(){
    const isNavOpen = document.getElementById("isNavOpen");
    const sidebar = document.getElementById("sidebar");
    const mainContainer = document.getElementById("mainContainer");
    const navButton = document.getElementById("navButton");


    if(isNavOpen.value == "0"){
        //close
        sidebar.classList.remove("navClose");
        sidebar.classList.add("navOpen");
        mainContainer.classList.remove("deactive-cont");
        mainContainer.classList.add("active-cont");
        navButton.innerText = "<";
        isNavOpen.value = "1";
    }else{
        //open
        sidebar.classList.remove("navOpen");
        sidebar.classList.add("navClose");
        mainContainer.classList.remove("active-cont");
        mainContainer.classList.add("deactive-cont");
        navButton.innerText = ">";
        isNavOpen.value = "0";
    }
    

}