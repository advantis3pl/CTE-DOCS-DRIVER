<?php echo "this is a test env." ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your existing head content -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

</head>
<body>

<form id="uploadForm" enctype="multipart/form-data">
    <input type="file" id="file">
    <button type="button" onclick="submitForm()">Submit</button>
</form>

<script>
    function submitForm() {
        let input = document.getElementById("file");
        var report = input.files[0];
        var reader = new FileReader();
        reader.onload = function (event) {
            var data = new Uint8Array(event.target.result);
            var workbook = XLSX.read(data, { type: 'array' });
            var sheetName = workbook.SheetNames[0];
            var worksheet = workbook.Sheets[sheetName];
            var excelData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

            excelData.shift();

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "testback.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            let res = xhr.responseText
                            console.log(res);
                        }else if(xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200){

                        }
                    };

                    const data2 = {
                        dataList : JSON.stringify(excelData)
                    };

                    var formData = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
                    xhr.send(formData);

        };
        reader.readAsArrayBuffer(report);
    }
</script>

</body>
</html>

