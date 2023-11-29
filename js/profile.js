function profileResetChanges(){
    const fixedUsername = document.getElementById("fixed_profile_username");
    const fixedFirstName = document.getElementById("fixed_profile_firstname");
    const fixedLastName = document.getElementById("fixed_profile_lastname");

    const username = document.getElementById("profile_username");
    const firstName = document.getElementById("profile_firstname");
    const lastName = document.getElementById("profile_lastname");

    document.getElementById("profile_details_error").innerText = ``;

    if(fixedUsername.value == username.value &&
        fixedFirstName.value == firstName.value &&
        fixedLastName.value == lastName.value){
            alert("No Changes");
        }else{
            username.value = fixedUsername.value;
            firstName.value = fixedFirstName.value;
            lastName.value = fixedLastName.value;
        }
}

function updateProfileDetails(){
    const fixedUsername = document.getElementById("fixed_profile_username");
    const fixedFirstName = document.getElementById("fixed_profile_firstname");
    const fixedLastName = document.getElementById("fixed_profile_lastname");

    const username = document.getElementById("profile_username");
    const firstName = document.getElementById("profile_firstname");
    const lastName = document.getElementById("profile_lastname");

    const formError = document.getElementById("profile_details_error");

    if(fixedUsername.value == username.value &&
        fixedFirstName.value == firstName.value &&
        fixedLastName.value == lastName.value){
            alert("No Changes to make!");
        }else{

            if(username.value != fixedUsername.value){
                validateUsername(username.value)
                .then((usernameVal) => {
                    if(usernameVal == "200"){
    
                        document.getElementById("new_p_username").value = username.value;
                        document.getElementById("new_p_firstname").value = firstName.value;
                        document.getElementById("new_p_lastname").value = lastName.value;
                        document.getElementById("new_p_submit").click();
                       
                    }else{
                       formError.innerHTML = `<p class="text-danger">Username already exists!</p>`;
                    }
                })
                .catch((error) => {
                    formError.innerHTML = `<p class="text-danger">Something went wrong</p>`;
                })
            }else{
                document.getElementById("new_p_username").value = username.value;
                document.getElementById("new_p_firstname").value = firstName.value;
                document.getElementById("new_p_lastname").value = lastName.value;
                document.getElementById("new_p_submit").click();
            }
            

        }
}


function updatePasswords(){
    const currentPassword = document.getElementById("profile_current_pass");
    const newPassword = document.getElementById("profile_new_pass");
    const confirmPassword = document.getElementById("profile_c_new_pass");

    const formError = document.getElementById("profile_password_error");

    if(currentPassword.value != "" && newPassword.value != "" && confirmPassword.value != ""){

        if(newPassword.value == confirmPassword.value){
            
            document.getElementById("up_form_current").value = currentPassword.value;
            document.getElementById("up_form_pass").value = newPassword.value;
            document.getElementById("up_form_c_pass").value = confirmPassword.value;
            document.getElementById("up_form_submit").click();

        }else{
            formError.innerHTML = `<p class="text-danger">New passwords are not matched!</p>`;
        }

    }else{
        formError.innerHTML = `<p class="text-danger">Empty Filed(s)</p>`;
    }

}