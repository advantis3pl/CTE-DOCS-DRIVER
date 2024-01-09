<form id="Form" action="" method="post">
   <input id="here" placeholder="scan..." type="text" required autofocus>
   <input id="submit" type="submit">
</form>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script>

<script>

    $('#here').keyup(function(){
        if(this.value.length == 10){
            $('#submit').click();
        }
    });

    document.getElementById('Form').addEventListener('submit', function (event) {
        event.preventDefault();
        console.log(document.getElementById("here").value);
        selectText("here");
    });

    function selectText(elementId) {
        var inputField = document.getElementById(elementId);
        inputField.select();
        inputField.setSelectionRange(0, inputField.value.length);
    }

</script>