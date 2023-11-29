const sapForm = document.getElementById('SAPUploadform');

sapForm.addEventListener('submit', function (event) {
    event.preventDefault(); 

    var fileInput = document.getElementById('sapReportFile');
    var file = fileInput.files[0];

    const sapReportError = document.getElementById("sapReportError");
    sapReportError.innerText = ``;

    const sapReportLoader = document.getElementById("sapReportUplaodLoader");

    sapReportLoader.classList.remove("d-none");
    sapReportLoader.classList.add("d-flex");

    if (file) {
        if (file.type === 'application/vnd.ms-excel' || file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {

            let resArray = getDataFromExcel(fileInput);
            if(resArray != "error"){
                resArray.then(function(array) {
                    let reportValidation = validateSAPReport(array);
                    if(reportValidation.status == 200){

                        let formatedArray = [];

                        for(var i = 1; i < array.length; i++){
                            formatedArray.push(array[i]);
                        }
                        
                        formatedArray = removeDuplicates(formatedArray);
                        formatedArray = convertCellstoDateSap(formatedArray);
                        formatedArray = convertNullToEmptyString(formatedArray);
                        formatedArray = convertEmptyToEmptyStringSAP(formatedArray);
                        console.log(formatedArray);

                    }else{
                        sapReportError.innerText = reportValidation.body;
                        sapReportLoader.classList.remove("d-flex");
                        sapReportLoader.classList.add("d-none");
                    }
                });
            }else{
                sapReportError.innerText = "Failed to read the uploaded excel file. Try again.";
                sapReportLoader.classList.remove("d-flex");
                sapReportLoader.classList.add("d-none");
            }

        } else {
            sapReportError.innerText = "Please upload a valid Excel file.";
            sapReportLoader.classList.remove("d-flex");
            sapReportLoader.classList.add("d-none");
        }
    } else {
        sapReportError.innerText = "Please choose a file to upload.";
        sapReportLoader.classList.remove("d-flex");
        sapReportLoader.classList.add("d-none");
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

function validateSAPReport(array){
    if(array[0].length == 6){

        if(array[0][0] != "Delivery"){
            return {
                status: 500,
                body: "The column name 1 is incorrect. it should be 'Delivery'."
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
        if(array[0][3] != "Act. Gds Mvmnt Date"){
            return {
                status: 500,
                body: "The column name 4 is incorrect. it should be 'Act. Gds Mvmnt Date'."
            };
        }
        if(array[0][4] != "Location of the ship-to party"){
            return {
                status: 500,
                body: "The column name 5 is incorrect. it should be 'Location of the ship-to party'."
            };
        }
        if(array[0][5] != "Created By"){
            return {
                status: 500,
                body: "The column name 6 is incorrect. it should be 'Created By'."
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


function convertCellstoDateSap(array){
    for(var x = 0; x < array.length; x++){
        let invoiceDate = array[x][3];
        if (invoiceDate != null) {
            array[x][3] = convertExcelDateToColomboTime(invoiceDate);
        }
    }
    return array;
}


function formatArray(array){
    var formatedArray = [];
    for(var i = 1; i < formatedArray.length; i++){
        formatedArray.add(array[i]);
    }
    return formatedArray;
}


function convertEmptyToEmptyStringSAP(arr) {
    return arr.map(innerArray =>
        Array.from({ length: 6 }, (_, index) =>
          innerArray[index] === undefined ? "" : innerArray[index]
        )
    );
}