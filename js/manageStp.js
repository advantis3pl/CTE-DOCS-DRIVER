function searchClient(){
    const clientID = document.getElementById("clientCode");
    const searchBtnCon = document.getElementById("searchBtnCon");
    const clientDBId = document.getElementById("clientDBId");
    const currentCode = document.getElementById("currentCode");
    const name = document.getElementById("clientName");
    const city = document.getElementById("clientCity");
    const address = document.getElementById("clientAddress");
    const route = document.getElementById("clientRoute");
    const status = document.getElementById("clientStatus");
    const errorCon = document.getElementById("shiptopartyFormError");
    const successCon = document.getElementById("shiptopartyFormSuccess");
    const mainRouteNumber = document.getElementById("mainRouteNumber");
    const btnCode = `<Button class="btn btn-secondary" onclick="searchClient()">Search</Button>`;
    const loaderCode = `<img src="images/loader.gif" alt="" width="30" height="30"></img>`;

    errorCon.innerText = "";
    successCon.innerText = "";

    if(clientID.value != ""){

        clientDBId.value = "";
        currentCode.value = "";
        name.value = "";
        city.value = "";
        address.value = "";
        route.value = "";
        status.value = "";
        mainRouteNumber.value = "";

        searchBtnCon.innerHTML = loaderCode;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "backend/manageSTP/getClient.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                let res = xhr.responseText
                let resObject = JSON.parse(res);

                if(resObject.requestStatus == 200){
                    clientDBId.value = resObject.id;
                    currentCode.value = resObject.code;
                    name.value = resObject.name;
                    city.value = resObject.city;
                    address.value = resObject.address;
                    route.value = resObject.route;
                    status.value = resObject.status;
                    searchBtnCon.innerHTML = btnCode;
                    mainRouteNumber.value = resObject.mainRoute;
                }else{

                    errorCon.innerText = resObject.message; 
                    searchBtnCon.innerHTML = btnCode;
                }

            }else if(xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200){
                errorCon.innerText = `Something went wrong!`; 
                searchBtnCon.innerHTML = btnCode;
            }
        };

        const data = {
            clientID : clientID.value
        };

        var formData = Object.keys(data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data[key])).join('&');
        xhr.send(formData);
    }else{

    }

}



function resetShipToPartyForm(){
    const clientID = document.getElementById("clientCode");
    const clientDBId = document.getElementById("clientDBId");
    const name = document.getElementById("clientName");
    const city = document.getElementById("clientCity");
    const address = document.getElementById("clientAddress");
    const route = document.getElementById("clientRoute");
    const status = document.getElementById("clientStatus");
    const currentCode = document.getElementById("currentCode");
    const successCon = document.getElementById("shiptopartyFormSuccess");
    const errorCon = document.getElementById("shiptopartyFormError");
    const mainRouteNumber = document.getElementById("mainRouteNumber");
    
    errorCon.innerText = "";
    successCon.innerText = "";
    clientID.value = "";
    clientDBId.value = "";
    name.value = "";
    city.value = "";
    address.value = "";
    route.value = "";
    status.value = "";
    currentCode.value = "";
    mainRouteNumber.value = "";
}


function saveClient(){

    const clientID = document.getElementById("clientCode");
    const searchBtnCon = document.getElementById("searchBtnCon");
    const clientDBId = document.getElementById("clientDBId");
    const currentCode = document.getElementById("currentCode");
    const name = document.getElementById("clientName");
    const city = document.getElementById("clientCity");
    const address = document.getElementById("clientAddress");
    const route = document.getElementById("clientRoute");
    const status = document.getElementById("clientStatus");
    const errorCon = document.getElementById("shiptopartyFormError");
    const successCon = document.getElementById("shiptopartyFormSuccess");
    const btnCode = `<Button class="btn btn-secondary" onclick="searchClient()">Search</Button>`;
    const loaderCode = `<img src="images/loader.gif" alt="" width="30" height="30"></img>`;

    errorCon.innerText = "";
    successCon.innerText = "";

    if(clientID.value != "" &&
    name.value != "" &&
    city.value != "" &&
    route.value != "none" &&
    status.value != "none"){

        searchBtnCon.innerHTML = loaderCode;

        validateClientCode(clientID.value)
        .then(response => {
            let resObject = JSON.parse(response);
            if(resObject.requestStatus == 200){

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "backend/manageSTP/addClient.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            let res = xhr.responseText.toString();
                            let resObject = JSON.parse(res);

                            if(resObject.requestStatus == 200){
                                searchBtnCon.innerHTML = btnCode;
                                successCon.innerText = "Client Added Successfully!";
                            }else{
                                searchBtnCon.innerHTML = btnCode;
                                errorCon.innerText = "Something went wrong!";
                            }

                        } else {
                            searchBtnCon.innerHTML = btnCode;
                            errorCon.innerText = "Something went wrong!";
                        }
                    }
                };
                const data = {
                    clientID : clientID.value,
                    name : name.value,
                    address : address.value,
                    city : city.value,
                    route : route.value,
                    status : status.value
                };
                var formData = Object.keys(data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data[key])).join('&');
                xhr.send(formData);

            }else{
                searchBtnCon.innerHTML = btnCode;
                errorCon.innerText = resObject.message;
            }
        })
        .catch(error => {
            searchBtnCon.innerHTML = btnCode;
            errorCon.innerText = `Something went wrong!`;
        });
        
    }else{
        errorCon.innerText = `Required fields are empty!`;
    }

}


function updateClient(){
    const clientID = document.getElementById("clientCode");
    const searchBtnCon = document.getElementById("searchBtnCon");
    const clientDBId = document.getElementById("clientDBId");
    const currentCode = document.getElementById("currentCode");
    const name = document.getElementById("clientName");
    const city = document.getElementById("clientCity");
    const address = document.getElementById("clientAddress");
    const route = document.getElementById("clientRoute");
    const status = document.getElementById("clientStatus");
    const errorCon = document.getElementById("shiptopartyFormError");
    const successCon = document.getElementById("shiptopartyFormSuccess");
    const mainRouteNumber = document.getElementById("mainRouteNumber");
    const btnCode = `<Button class="btn btn-secondary" onclick="searchClient()">Search</Button>`;
    const loaderCode = `<img src="images/loader.gif" alt="" width="30" height="30"></img>`;

    successCon.innerText = "";
    errorCon.innerText = "";

    if(clientDBId.value != "" &&
    clientID.value != "" &&
    name.value != "" &&
    address.value != "" &&
    city.value != "" &&
    route.value != "none" &&
    currentCode.value != "" &&
    status.value != "none"){

        if(currentCode.value == clientID.value){

            searchBtnCon.innerHTML = loaderCode;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "backend/manageSTP/updateClient.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    let res = xhr.responseText
                    let resObject = JSON.parse(res);
                    if(resObject.requestStatus == 200){
                        searchClient();
                        successCon.innerText = `Client updated successfully!`;
                    }else{
                        errorCon.innerText = resObject.message; 
                        searchBtnCon.innerHTML = btnCode;
                    }

                }else if(xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200){
                    errorCon.innerText = `Something went wrong!`; 
                    searchBtnCon.innerHTML = btnCode;
                }
            };
            const data = {
                clientDBId : clientDBId.value,
                clientID : clientID.value,
                name : name.value,
                address : address.value,
                city : city.value,
                route : route.value,
                status : status.value,
                mainRoute: mainRouteNumber.value
            };
            var formData = Object.keys(data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data[key])).join('&');
            xhr.send(formData);

        }else{
            errorCon.innerText = `Cannot update the Ship-to-party Code!`;
        }

    }else{
        errorCon.innerText = `Required fileds cannot be empty!`;
    }

}

function validateClientCode(clientID){
    var response = {
        'requestStatus': 500,
        'message': 'Something went wrong!'
    };
    var jsonString = JSON.stringify(response);
    return new Promise((resolve, reject) => {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "backend/manageSTP/validateCode.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    let res = xhr.responseText.toString();
                    resolve(res);
                } else {
                    resolve(jsonString);
                }
            }
        };
        const data = {
            code: clientID
        };
        var formData = Object.keys(data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data[key])).join('&');
        xhr.send(formData);
    });
}


function downloadPDF() {
    const element = document.getElementById('clientListCon');
    const pdf = new jsPDF();
    html2canvas(element).then(canvas => {
      const imgData = canvas.toDataURL('image/png');
      pdf.addImage(imgData, 'PNG', 10, 10, 190, 0);
      pdf.save('clientList.pdf');
    });
}