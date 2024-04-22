//pop up windows
function addUserPopUp(){
    const popUpContainer5 = document.getElementById("addUserPopUp");
    popUpContainer5.style.display = "block";
}
function editUserPopUp(id,fname,lname,username,type,status,lastLogin){

    const firstName = document.getElementById("vu_fname");
    const lastName = document.getElementById("vu_lname");
    const username_field = document.getElementById("vu_username");
    const usertype = document.getElementById("vu_usertype");
    const status_field = document.getElementById("vu_status");
    const lastLogin_field = document.getElementById("vu_last_login");

    const vu_selectedUserId = document.getElementById("vu_selectedUserId");
    const vu_fixed_fname = document.getElementById("vu_fixed_fname");
    const vu_fixed_lname = document.getElementById("vu_fixed_lname");
    const vu_fixed_username = document.getElementById("vu_fixed_username");
    const vu_fixed_usertype = document.getElementById("vu_fixed_usertype");
    const vu_fixed_status = document.getElementById("vu_fixed_status");

    firstName.value = fname; 
    lastName.value = lname; 
    username_field.value = username; 
    usertype.value = type; 
    status_field.value = status;
    lastLogin_field.value = lastLogin;
    vu_selectedUserId.value = id;

    vu_fixed_fname.value = fname;
    vu_fixed_lname.value = lname;
    vu_fixed_username.value = username;
    vu_fixed_usertype.value = type;
    vu_fixed_status.value = status;

    const popUpContainer6 = document.getElementById("viewUserPopUp");
    popUpContainer6.style.display = "block";

}


//user delete
function userDeleteWindow(){
    const vu_fixed_username = document.getElementById("vu_fixed_username").value;
    document.getElementById("delteUserText").innerHTML = `<p class="font-bold">Are you sure?</p> Deleting User: ${vu_fixed_username} will permanently remove the user from the system.`;
    const popUpContainer6 = document.getElementById("viewUserPopUp");
    popUpContainer6.style.display = "none";
    document.getElementById("viewDeleteUser").style.display = "block";
}
function backFromUserDelete(){
    document.getElementById("viewUserPopUp").style.display = "block";
    document.getElementById("viewDeleteUser").style.display = "none";
}
function deleteUserFromSystem(){
    const vu_fixed_ID = document.getElementById("vu_selectedUserId").value;
    document.getElementById("du_userID").value = vu_fixed_ID;
    document.getElementById("du_submit").click();
}


//edit user
function loginHistory(){
    const username = document.getElementById("vu_fixed_username").value;
    window.location.replace(`loginHistory.php?id=${username}`);
}
function actionHistory(){
    const userid = document.getElementById("vu_selectedUserId").value;
    window.location.replace(`actionHistory.php?id=${userid}`);
}
function resetVUuserDetails(){
    document.getElementById("vu_fname").value = document.getElementById("vu_fixed_fname").value;
    document.getElementById("vu_lname").value = document.getElementById("vu_fixed_lname").value;
    document.getElementById("vu_username").value = document.getElementById("vu_fixed_username").value;
    document.getElementById("vu_usertype").value = document.getElementById("vu_fixed_usertype").value;
    document.getElementById("vu_status").value = document.getElementById("vu_fixed_status").value;
}
function updateUserDetails(){
    const firstName = document.getElementById("vu_fname");
    const lastName = document.getElementById("vu_lname");
    const username = document.getElementById("vu_username");
    const usertype = document.getElementById("vu_usertype");
    const status = document.getElementById("vu_status");
    
    const vu_selectedUserId = document.getElementById("vu_selectedUserId");
    const vu_fixed_fname = document.getElementById("vu_fixed_fname");
    const vu_fixed_lname = document.getElementById("vu_fixed_lname");
    const vu_fixed_username = document.getElementById("vu_fixed_username");
    const vu_fixed_usertype = document.getElementById("vu_fixed_usertype");
    const vu_fixed_status = document.getElementById("vu_fixed_status"); 

    const vuPopUpLoader = document.getElementById("vuPopUpLoader");
    const vuFormError = document.getElementById("vuFormError");
    vuFormError.innerText = ``;

    const formChanges = document.getElementById("au_formChanges");

    if(firstName.value != "" && lastName.value != "" && username.value != "" &&
    usertype.value != "" && status.value != ""){

        if(firstName.value == vu_fixed_fname.value && lastName.value == vu_fixed_lname.value &&
            username.value == vu_fixed_username.value && usertype.value == vu_fixed_usertype.value &&
            status.value == vu_fixed_status.value){
                alert("No changes to make.");
            }else{
                
                if(username.value != vu_fixed_username.value){
                    vuPopUpLoader.style.display = "flex";
                    validateUsername(username.value)
                    .then((usernameVal) => {
                        if(usernameVal == "200"){
            
                            var xhr2 = new XMLHttpRequest();
                            xhr2.open("POST", "backend/user.php", true);
                            xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr2.onreadystatechange = function () {
                                if (xhr2.readyState === 4) {
                                    if (xhr2.status === 200) {
                                        let res2 = xhr2.responseText.toString()
                                        if(res2.trim() == "200"){
                                            alert("User updated successfully!");
                                            vu_fixed_fname.value = firstName.value;
                                            vu_fixed_lname.value = lastName.value;
                                            vu_fixed_username.value = username.value;
                                            vu_fixed_usertype.value = usertype.value;
                                            vu_fixed_status.value = status.value;
                                            formChanges.value = "1";
            
                                        }else{
                                            alert("Something went wrong. Try again!");
                                            firstName.value = vu_fixed_fname.value;
                                            lastName.value = vu_fixed_lname.value;
                                            username.value = vu_fixed_username.value;
                                            usertype.value = vu_fixed_usertype.value;
                                            status.value = vu_fixed_status.value;
                                        }
                                        vuPopUpLoader.style.display = "none";
                                    } else {
                                        vuPopUpLoader.style.display = "none";
                                        alert("Something went wrong. Try again!");
                                        firstName.value = vu_fixed_fname.value;
                                        lastName.value = vu_fixed_lname.value;
                                        username.value = vu_fixed_username.value;
                                        usertype.value = vu_fixed_usertype.value;
                                        status.value = vu_fixed_status.value;
                                    }
                                }
                            };
                            const data2 = {
                                action: "update",
                                fname: firstName.value,
                                lname: lastName.value,
                                username: username.value,
                                usertype: usertype.value,
                                status: status.value,
                                selectedUserId: vu_selectedUserId.value
                            };
                            var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
                            xhr2.send(formData2);
            
                        }else{
                            vuPopUpLoader.style.display = "none";
                            vuFormError.innerText = "Username already exists.";
                        }
                    })
                    .catch((error) => {
                        vuPopUpLoader.style.display = "none";
                        alert("Something went wrong. Try again!");
                    });
        
        
                }else{
                    vuPopUpLoader.style.display = "flex";
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "backend/user.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            let res = xhr.responseText
                            if(res.trim() == "200"){
                                console.log(res);
                                alert("User updated successfully!");
                                vu_fixed_fname.value = firstName.value;
                                vu_fixed_lname.value = lastName.value;
                                vu_fixed_username.value = username.value;
                                vu_fixed_usertype.value = usertype.value;
                                vu_fixed_status.value = status.value;
                                vuPopUpLoader.style.display = "none";
                                formChanges.value = "1";
                            }else{
                                alert("Something went wrong. Try again!");
                                firstName.value = vu_fixed_fname.value;
                                lastName.value = vu_fixed_lname.value;
                                username.value = vu_fixed_username.value;
                                usertype.value = vu_fixed_usertype.value;
                                status.value = vu_fixed_status.value;
                                vuPopUpLoader.style.display = "none";
                            }
                            
                        }else if(xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200){
                            alert("Something went wrong. Try again!");
                            firstName.value = vu_fixed_fname.value;
                            lastName.value = vu_fixed_lname.value;
                            username.value = vu_fixed_username.value;
                            usertype.value = vu_fixed_usertype.value;
                            status.value = vu_fixed_status.value;
                            vuPopUpLoader.style.display = "none";
                        }
                    };
                    
                    const data2 = {
                        action: "update",
                        fname: firstName.value,
                        lname: lastName.value,
                        username: username.value,
                        usertype: usertype.value,
                        status: status.value,
                        selectedUserId: vu_selectedUserId.value
                    };
                    var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
                    xhr.send(formData2);
                }
            }

    }else{
        vuFormError.innerText = `Required fields are empty!`;
    }
}
function openSecuritySettings(){
    const adminPass = document.getElementById("vu_admin_pass").value;
    const selectedUserId = document.getElementById("vu_selectedUserId").value;
    if(adminPass != ""){
        document.getElementById("vu_admin_password").value = adminPass;
        document.getElementById("vu_selected_userid_admin").value = selectedUserId;
        document.getElementById("vu_s_settings_submit").click();
    }else{
        alert("Enter you admin password");
    }
}


//add user
function addUser(){

    const fname = document.getElementById("au_fname");
    const lname = document.getElementById("au_lname");
    const username = document.getElementById("au_username");
    const usertype = document.getElementById("au_usertype");
    const password = document.getElementById("au_password");
    const cPassword = document.getElementById("au_cpassword");
    const status = document.getElementById("au_status");

    const auFormError = document.getElementById("auFormError");
    const auPopUpLoader = document.getElementById("auPopUpLoader");

    let auValidation = auFormValidation(fname,lname,username,usertype,password,cPassword,status);

    if(auValidation == "success"){
        auFormError.innerText = "";
        auPopUpLoader.style.display = "flex";

        validateUsername(username.value)
        .then((usernameVal) => {
            
            if(usernameVal == "200"){

                var xhr2 = new XMLHttpRequest();
                xhr2.open("POST", "backend/user.php", true);
                xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr2.onreadystatechange = function () {
                    if (xhr2.readyState === 4) {
                        if (xhr2.status === 200) {
                            let res2 = xhr2.responseText.toString()
                            if(res2.trim() == "200"){
                                window.location.reload();
                            }else{
                                auPopUpLoader.style.display = "none";
                                auFormError.innerText = "Something went wrong. Try again.";
                            }
                        } else {
                            auPopUpLoader.style.display = "none";
                            auFormError.innerText = "Something went wrong. Try again.";
                        }
                    }
                };
                const data2 = {
                    fname: fname.value,
                    lname: lname.value,
                    username: username.value,
                    usertype: usertype.value,
                    password: password.value,
                    status: status.value
                };
                var formData2 = Object.keys(data2).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data2[key])).join('&');
                xhr2.send(formData2);

            }else{
                auPopUpLoader.style.display = "none";
                auFormError.innerText = "Username already exists.";
            }
        })
        .catch((error) => {
            auPopUpLoader.style.display = "none";
            auFormError.innerText = "Something went wrong. Try again.";
        });



    }else{
        auFormError.innerText = auValidation;
    }

}
function auFormValidation(fname,lname,username,usertype,password,cPassword,status){
    if(fname.value == ""){
        return "First name cannot be empty";  
    }
    if(lname.value == ""){
        return "Last name cannot be empty";  
    }
    if(username.value == ""){
        return "Username cannot be empty";  
    }
    if(usertype.value == ""){
        return "Usertype cannot be empty";  
    }
    if(password.value == ""){
        return "Password cannot be empty";  
    }
    if(cPassword.value == ""){
        return "Confirm Password name cannot be empty";  
    }
    if(status.value == ""){
        return "Status cannot be empty";  
    }
    if(password.value != cPassword.value){
        return "Passwords are not matching";  
    }
    return "success";
}


//common
function validateUsername(username) {
    return new Promise((resolve, reject) => {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "backend/user.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    let res = xhr.responseText.toString();
                    resolve(res.trim());
                } else {
                    reject("500");
                }
            }
        };
        const data = {
            userNameValidation: username
        };
        var formData = Object.keys(data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data[key])).join('&');
        xhr.send(formData);
    });
}
function closeVUForm(){
    const formChanges = document.getElementById("au_formChanges").value;

    if(formChanges == 1){
        window.location.reload();
    }else{
        const popUpContainer6 = document.getElementById("viewUserPopUp");
        popUpContainer6.style.display = "none";
    }
    
}