const stpError = document.getElementById("stpError");
const stpFromDate = document.getElementById("stpFromDate");
const stpToDate = document.getElementById("stpToDate");
const stpReportType = document.getElementById("stpReportType");

//buttons
const excelButton = document.getElementById("downloadExcelBtn");
const pdfButton = document.getElementById("downloadPDFBtn");

function downloadReport(id){
    stpError.innerText = ``;
    if(stpFromDate.value != "" && stpToDate.value != ""){

        var formatedFromDate = new Date(stpFromDate.value);
        var formatedToDate = new Date(stpToDate.value);

        if (formatedFromDate <= formatedToDate) {

            if(id == "excel"){
                excelDownloadLoading("On");
            }else if(id == "pdf"){
                pdfDownloadLoading("On");
            }

            //send the request to the backend 
            var xhr2 = new XMLHttpRequest();
            xhr2.open("POST", "backend/stpReport/getReportData.php", true);
            xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr2.onreadystatechange = function () {
                if (xhr2.readyState === 4) {
                    if (xhr2.status === 200) {
                        
                        let res2 = xhr2.responseText.toString();
                        //console.log(res2);
                        let jsonRes = JSON.parse(res2);
                        if(jsonRes.requestStatus == 200){
                            let records = JSON.parse(jsonRes.records);

                            if(records.length != 0){
                                if(id == "excel"){
                                    downloadExcel(records,stpReportType.value);
                                }else if(id == "pdf"){
                                    formatAndDownloadPDF(records,stpReportType.value);
                                }
                            }else{
                                //0 records were found
                                stpError.innerText = "0 Records were found.";
                                excelDownloadLoading("Off");
                                pdfDownloadLoading("Off");
                            }
                        }else{
                            excelDownloadLoading("Off");
                            pdfDownloadLoading("Off");
                            stpError.innerText = `Something went wrong!`;
                        }
                        
                    } else {
                        excelDownloadLoading("Off");
                        pdfDownloadLoading("Off");
                        stpError.innerText = `Something went wrong!`;
                    }
                }
            };
            const data2 = {
                reportType: stpReportType.value,
                from: stpFromDate.value,
                to:stpToDate.value
            };
            var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
            xhr2.send(formData2);

        }else{
            stpError.innerText = `Invalid date range!`;
        }

    }else{
        stpError.innerText = `Report / From Date / To Date cannot be empty!`;
    }
}


function excelDownloadLoading(val){
    if(val == "On"){
        excelButton.disabled = true; 
        pdfButton.disabled = true; 
        excelButton.innerHTML = `<img src="images/loader.gif" alt="" width="15" height="15">`;
    }else{
        excelButton.disabled = false;  
        pdfButton.disabled = false;
        excelButton.innerHTML = `Excel`;
    }
}

function pdfDownloadLoading(val){
    if(val == "On"){
        pdfButton.disabled = true; 
        excelButton.disabled = true; 
        pdfButton.innerHTML = `<img src="images/loader.gif" alt="" width="15" height="15">`;
    }else{
        pdfButton.disabled = false;  
        excelButton.disabled = false;
        pdfButton.innerHTML = `PDF`;
    }
}

function downloadExcel(data, fileName) {
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(data);
  
    // Add styling to the sheet
    const headerLength = data[1].length;
  
    // Style for header row
    const headerRange = { s: { r: 0, c: 0 }, e: { r: 0, c: headerLength - 1 } };
    ws['!merges'] = [headerRange];
    ws[headerRange.s] = {
      font: { bold: true, color: { rgb: 'FFFFFF' } },
      fill: { fgColor: { rgb: '336699' } }, // Background color
      alignment: { horizontal: 'center' },
      border: { top: { style: 'thin' }, bottom: { style: 'thin' }, left: { style: 'thin' }, right: { style: 'thin' } } // Add borders
    };
  
    // Style for data rows
    for (let R = 1; R < data.length; ++R) { // Start from 1 to exclude header
      for (let C = 0; C < headerLength; ++C) {
        const cellRef = XLSX.utils.encode_cell({ r: R, c: C });
        if (!ws[cellRef]) ws[cellRef] = {};
        ws[cellRef].s = { border: { top: { style: 'thin' }, bottom: { style: 'thin' }, left: { style: 'thin' }, right: { style: 'thin' } } };
  
        // Center text in cell 1
        if (R === 0 && C === 0) {
          ws[cellRef].s.alignment = { horizontal: 'center' };
        }
  
        // Apply background color to cells in row 2 with data
        if (R === 1 && data[R][C]) {
          ws[cellRef].s.fill = { fgColor: { rgb: 'CCFFCC' } }; // Light green background
        }
      }
    }
  
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet 1');
    const wbout = XLSX.write(wb, { bookType: 'xlsx', bookSST: true, type: 'binary' });
    const blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `${fileName}.xlsx`;
    link.click();
    excelDownloadLoading("Off");
  }
  
  
  
  // Helper function to convert s to array buffer
  function s2ab(s) {
    const buf = new ArrayBuffer(s.length);
    const view = new Uint8Array(buf);
    for (let i = 0; i !== s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
    return buf;
  }



function formatAndDownloadPDF(data, fileName){

    for (let i = 0; i < data.length; i++) {
        // Loop through the inner arrays
        for (let j = 0; j < data[i].length; j++) {
            // Convert each element to a string
            data[i][j] = data[i][j].toString();
        }
    }

    if(fileName == "nddn_report"){
        var array = [];
        for(var i = 0; i < data.length; i++){
            if(i == 0){
                array.push([data[i][0]]);
            }else{
                array.push(
                    [data[i][0],data[i][1],data[i][2],data[i][3],data[i][4],data[i][7],data[i][8]]
                )
            }

            if(i + 1 == data.length){
                generatePDF(array,fileName,'landscape',8);
            }
        }

    }else if(fileName == "sdr_report"){

        var array = [];
        for(var i = 0; i < data.length; i++){
            if(i == 0){
                array.push([data[i][0]]);
            }else{
                array.push(
                    [data[i][0],data[i][1],data[i][2],data[i][3],data[i][4],data[i][7],data[i][8]]
                )
            }

            if(i + 1 == data.length){
                generatePDF(array,fileName,'landscape',8);
            }
        }

    }else if(fileName == "pending_collection_report"){

        generatePDF(data,fileName,'portrait',8);

    }else if(fileName == "customer_collection_report"){

        generatePDF(data,fileName,'portrait',8);

    }else if(fileName == "special_collection_report"){

        generatePDF(data,fileName,'portrait',8);

    }else if(fileName == "reconcile_report"){

        var array = [];
        for(var i = 0; i < data.length; i++){
            if(i == 0){
                array.push([data[i][0]]);
            }else{
                array.push(
                    [
                        data[i][0],
                        data[i][1],
                        data[i][2],
                        data[i][3],
                        data[i][4],
                        data[i][6],
                        data[i][7],
                        data[i][8],
                        data[i][9],
                        data[i][10],
                        data[i][11],
                        data[i][15]
                    ]
                )
            }

            if(i + 1 == data.length){
                generatePDF(array,fileName,'landscape',7);
            }
        }

    }else if(fileName == "distribution_summary"){
        generatePDF(data,fileName,'portrait',8);
    }

}

function generatePDF(data,fileName,paperType,fontSize) {
    const { jsPDF } = window.jspdf;

    const doc = new jsPDF({
        orientation: `${paperType}`,
        unit: 'mm',
        format: 'a4',
    });

    // Set title font size and position
    doc.setFontSize(12);
    doc.text(data[0][0], doc.internal.pageSize.getWidth() / 2, 10, { align: 'center' });

    // Flatten the nested arrays
    const headers = data[1].map(column => column);
    const rows = data.slice(2).map(row => row.map(cell => cell));

    // Move the starting position below the title
    doc.autoTable({
        head: [headers],
        body: rows,
        startY: 20,
        styles: {
            fontSize: fontSize,
            cellPadding: 1.5,
            fillColor: [255,255,255], // Header background color (black)
            textColor: [0, 0, 0], // Header text color (white)
        },
        theme: 'grid', // 'striped', 'grid', 'plain'
    });

    doc.save(`${fileName}.pdf`);
    pdfDownloadLoading("Off");
}
