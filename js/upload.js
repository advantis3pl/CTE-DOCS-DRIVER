function expand(id,i){
    const container = document.getElementById(id);
    const input = document.getElementById(i);

    if(input.value == "off"){
        container.style.height = "250px";
        input.value = "on";
    }else{
        container.style.height = "42px";
        input.value = "off";
    }

}