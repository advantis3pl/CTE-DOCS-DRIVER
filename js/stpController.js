const stpError = document.getElementById("stpError");
const stpFromDate = document.getElementById("stpFromDate");
const stpToDate = document.getElementById("stpToDate");
const stpReportType = document.getElementById("stpReportType");

//buttons
const excelButton = document.getElementById("downloadExcelBtn");
const pdfButton = document.getElementById("downloadPDFBtn");

function stpDownloadExcel(){
    stpError.innerText = ``;
    if(stpFromDate.value != "" && stpToDate.value != ""){

        var formatedFromDate = new Date(stpFromDate.value);
        var formatedToDate = new Date(stpToDate.value);

        if (formatedFromDate <= formatedToDate) {

            excelDownloadLoading("On");
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
                                downloadExcel(records,stpReportType.value);
                            }else{
                                //0 records were found
                                stpError.innerText = "0 Records were found.";
                                excelDownloadLoading("Off");
                            }
                        }
                        
                    } else {
                        stopLoadingND();
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

function stpDownloadPDF(){
    stpError.innerText = ``;
    if(stpFromDate.value != "" && stpToDate.value != ""){
        pdfDownloadLoading("On");
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
        pdfButton.innerHTML = `Excel`;
    }
}


function downloadExcel(data, fileName) {
  const wb = XLSX.utils.book_new();
  const ws = XLSX.utils.aoa_to_sheet(data);
  XLSX.utils.book_append_sheet(wb, ws, 'Sheet 1');
  const wbout = XLSX.write(wb, { bookType: 'xlsx', bookSST: true, type: 'binary' });
  const blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' });
  const link = document.createElement('a');
  link.href = URL.createObjectURL(blob);
  link.download = `${fileName}.xlsx`;
  link.click();
  excelDownloadLoading("Off");
}

function s2ab(s) {
  const buf = new ArrayBuffer(s.length);
  const view = new Uint8Array(buf);
  for (let i = 0; i < s.length; i++) {
    view[i] = s.charCodeAt(i) & 0xFF;
  }
  return buf;
}
  