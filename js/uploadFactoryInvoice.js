const factoryForm = document.getElementById('factoryInvoiceForm');

factoryForm.addEventListener('submit', function (event) {
    event.preventDefault(); 
    var fileInput = document.getElementById('factoryInvoiceFile');
    var file = fileInput.files[0];

    const factoryReportError = document.getElementById("factoryInvoiceError");
    factoryReportError.innerText = ``;

    const factoryReportLoader = document.getElementById("factoryInvoiceUploadLoader");

    factoryReportLoader.classList.remove("d-none");
    factoryReportLoader.classList.add("d-flex");

    if (file) {
        if (file.type === 'application/vnd.ms-excel' || file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {

            let resArray = getDataFromExcel(fileInput);
            if(resArray != "error"){
                resArray.then(function(array) {
                    let reportValidation = validateSAPReportFactory(array);
                    if(reportValidation.status == 200){

                        let formatedArray = [];

                        for(var i = 1; i < array.length; i++){
                            formatedArray.push(array[i]);
                        }

                        formatedArray = convertCellstoDateFactory(formatedArray);
                        formatedArray = removeDuplicates(formatedArray);
                        formatedArray = convertNullToEmptyString(formatedArray);
                        formatedArray = convertEmptyToEmptyStringFactory(formatedArray);

                        ValidateDeliveryNumbers(formatedArray)
                        .then(response => {
                            let resObject = JSON.parse(response);
                            if(resObject.requestStatus == 200){

                                var xhr2 = new XMLHttpRequest();
                                xhr2.open("POST", "backend/upload/uploadFactory.php", true);
                                xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                xhr2.onreadystatechange = function () {
                                    if (xhr2.readyState === 4) {
                                        if (xhr2.status === 200) {
                                            let res2 = xhr2.responseText.toString();
                                            let resObject2 = JSON.parse(res2);
                                            if(resObject2.requestStatus == 200){
                                                alert(resObject2.message);
                                                factoryReportLoader.classList.remove("d-flex");
                                                factoryReportLoader.classList.add("d-none");
                                            }else{
                                                factoryReportError.innerText = resObject2.message;
                                                factoryReportLoader.classList.remove("d-flex");
                                                factoryReportLoader.classList.add("d-none");
                                            }
                                            
                                        } else {
                                            factoryReportError.innerText = "Something went wrong!";
                                            factoryReportLoader.classList.remove("d-flex");
                                            factoryReportLoader.classList.add("d-none");
                                        }
                                    }
                                };
                                const data = {
                                    type: "Factory",
                                    report: JSON.stringify(formatedArray)
                                };
                                var formData2 = Object.keys(data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data[key])).join('&');
                                xhr2.send(formData2);

                            }else{
                                factoryReportError.innerText = resObject.message;
                                factoryReportLoader.classList.remove("d-flex");
                                factoryReportLoader.classList.add("d-none");
                            }
                        })
                        .catch(error => {
                            factoryReportError.innerText = "Something went wrong!";
                            factoryReportLoader.classList.remove("d-flex");
                            factoryReportLoader.classList.add("d-none");
                        });


                    }else{
                        factoryReportError.innerText = reportValidation.body;
                        factoryReportLoader.classList.remove("d-flex");
                        factoryReportLoader.classList.add("d-none");
                    }
                });
            }else{
                factoryReportError.innerText = "Failed to read the uploaded excel file. Try again.";
                factoryReportLoader.classList.remove("d-flex");
                factoryReportLoader.classList.add("d-none");
            }

        } else {
            factoryReportError.innerText = "Please upload a valid Excel file.";
            factoryReportLoader.classList.remove("d-flex");
            factoryReportLoader.classList.add("d-none");
        }
    } else {
        factoryReportError.innerText = "Please choose a file to upload.";
        factoryReportLoader.classList.remove("d-flex");
        factoryReportLoader.classList.add("d-none");
    }
});


function getDataFromExcel(input){
    try {
        return new Promise((resolve, reject) => {
            var report = input.files[0];
            var reader = new FileReader();
            reader.onload = function (event) {
                var data = new Uint8Array(event.target.result);
                var workbook = XLSX.read(data, { type: 'array' });
                var sheetName = workbook.SheetNames[0];
                var worksheet = workbook.Sheets[sheetName];
                var excelData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
                resolve(excelData);
            };
            reader.readAsArrayBuffer(report);
        });
    } catch (error) {
      return "error";
    }
}  

function validateSAPReportFactory(array){
    if(array[0].length == 9){

        if(array[0][0] != "Delivery Note"){
            return {
                status: 500,
                body: "The column name 1 is incorrect. it should be 'Delivery Note'."
            };
        }
        if(array[0][1] != "Ship-To Party"){
            return {
                status: 500,
                body: "The column name 2 is incorrect. it should be 'Ship-To Party'."
            };
        }
        if(array[0][2] != "Name of the ship-to party"){
            return {
                status: 500,
                body: "The column name 3 is incorrect. it should be 'Name of the ship-to party'."
            };
        }
        if(array[0][3] != "Invoice Date"){
            return {
                status: 500,
                body: "The column name 4 is incorrect. it should be 'Invoice Date'."
            };
        }
        if(array[0][4] != "Location of the ship-to party"){
            return {
                status: 500,
                body: "The column name 5 is incorrect. it should be 'Location of the ship-to party'."
            };
        }
        if(array[0][5] != "SAP ID"){
            return {
                status: 500,
                body: "The column name 6 is incorrect. it should be 'SAP ID'."
            };
        }
        if(array[0][6] != "Sending Date"){
            return {
                status: 500,
                body: "The column name 7 is incorrect. it should be 'Sending Date'."
            };
        }
        if(array[0][7] != "Production tranfer #"){
            return {
                status: 500,
                body: "The column name 8 is incorrect. it should be 'Production tranfer #'."
            };
        }
        if(array[0][8] != `Remarks\\Request person`){
            return {
                status: 500,
                body: `The column name 9 is incorrect. it should be 'Remarks\\Request person'.`
            };
        }

        return {
            status: 200,
            body: "Success"
        };

    }else{
        return {
            status: 500,
            body: "Column count is wrong!"
        };
    }
}


function convertCellstoDateFactory(array){
    for(var x = 0; x < array.length; x++){
        let invoiceDate = array[x][3];
        let sendingDate = array[x][6];
        let productionTransfer = array[x][7];
        if (invoiceDate != null) {
            array[x][3] = convertExcelDateToColomboTime(invoiceDate);
        }
        if (sendingDate != null) {
            array[x][6] = convertExcelDateToColomboTime(sendingDate);
        }
        if (productionTransfer != null && productionTransfer != "SPD") {
            array[x][7] = convertExcelDateTimeToColomboTime(productionTransfer);
        }
    }
    return array;
}



function convertExcelDateToColomboTime(excelDate) {

    const millisecondsSince1900 = (excelDate - 2) * 24 * 60 * 60 * 1000;
    const jsDate = new Date(1900, 0, 1, 0, 0, 0, 0);
    jsDate.setTime(jsDate.getTime() + millisecondsSince1900);
    const colomboDate = new Date(jsDate);
    colomboDate.setMinutes(jsDate.getMinutes() - jsDate.getTimezoneOffset() + 330);

    let dateString = `${colomboDate.getFullYear()}/${colomboDate.getMonth() + 1}/${colomboDate.getDate()}`;
    return dateString;

}


function convertExcelDateTimeToColomboTime(excelTime) {
    var millisecondsInDay = 24 * 60 * 60 * 1000;
    var milliseconds = excelTime * millisecondsInDay;

    var date = new Date(milliseconds);

    var hours = date.getUTCHours();
    var minutes = date.getUTCMinutes();
    var seconds = date.getUTCSeconds();

    var formattedTime = padZero(hours) + ':' + padZero(minutes) + ':' + padZero(seconds);

    return formattedTime;
}

function padZero(num) {
    return (num < 10 ? '0' : '') + num;
}


function removeDuplicates(array) {
    const uniqueDeliveryNumbers = {};
    const resultArray = [];

    for (const element of array) {
        const deliveryNumber = element[0];

        if (!uniqueDeliveryNumbers[deliveryNumber]) {
            resultArray.push(element);
            uniqueDeliveryNumbers[deliveryNumber] = true;
        }
    }

    return resultArray;
}

function convertNullToEmptyString(arr) {
    return arr.map(element => (element === undefined || element === null) ? "" : element);
}

function convertEmptyToEmptyStringFactory(arr) {
    return arr.map(innerArray =>
        Array.from({ length: 9 }, (_, index) =>
          innerArray[index] === undefined ? "" : innerArray[index]
        )
    );
}




function ValidateDeliveryNumbers(array) {

    var deliveryNumbers = array.map(function(innerArray) {
        return innerArray[0];
    });
    var response = {
        'requestStatus': 500,
        'message': 'Something went wrong!'
    };
    var jsonString = JSON.stringify(response);

    return new Promise((resolve, reject) => {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "backend/upload/validateDN.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    let res = xhr.responseText.toString();
                    resolve(res.trim());
                } else {
                    resolve(jsonString);
                }
            }
        };
        const data = {
            report: JSON.stringify(deliveryNumbers)
        };
        var formData2 = Object.keys(data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data[key])).join('&');
        xhr.send(formData2);
    });

}