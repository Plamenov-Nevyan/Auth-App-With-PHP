
let registerInputs = document.querySelectorAll('.register-input')
let loginInputs = document.querySelectorAll('.login-input')
let registerForm = document.getElementById('register-form')
let loginForm = document.getElementById('login-form')
let passwordValRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/

if(registerForm !== null){
    registerForm.addEventListener('submit', (e) => validateRegisterForm(e))
}
if(loginForm !== null){
    loginForm.addEventListener('submit', (e) => validateLoginForm(e))
}
 // remove errors when inputs are on focus
Array.from(registerInputs).forEach(input => {
    input.addEventListener('focus', (e) => {
        let errorSpan = document.getElementById(`${input.id}-error`)
        errorSpan.textContent = ''
        errorSpan.style.display = 'none'
    })
})

Array.from(loginInputs).forEach(input => {
    input.addEventListener('focus', (e) => {
        let errorSpan = document.getElementById(`${input.id}-login-error`)
        errorSpan.textContent = ''
        errorSpan.style.display = 'none'
    })
})

function validateRegisterForm(e){
    e.preventDefault()
    let errors = checkForEmptyInputs(registerInputs)  // check for empty inputs
    // if there are no empty inputs, check their validity
    if(Object.values(errors).every(val => val === null)){
       errors = {...inputsValidator(registerInputs, errors)}
    }
    //visualize errors through every error span corresponding to its input sibling
    if(Object.values(errors).some(val => val !== null)){
      visualizeErrors(errors, 'register')
    }else{ 
        sendData(        // if everything's alright send the user data to the register handler to be processed
            {
                username : registerInputs[0].value,
                email: registerInputs[1].value,
                phone: registerInputs[2].value,
                password: registerInputs[3].value
            },
            'register'
        )
    }
}

function validateLoginForm(e){
    e.preventDefault()
    let errors = checkForEmptyInputs(loginInputs) // check for empty inputs
    // if there are no empty inputs, check their validity
    if(Object.values(errors).every(val => val === null)){
       errors = {...inputsValidator(loginInputs, errors)}
    }
    //visualize errors through every error span corresponding to its input sibling
    if(Object.values(errors).some(val => val !== null)){
        visualizeErrors(errors, 'login')
    }else{
        sendData(   // if everything's alright send the user data to the login handler to be processed
            {
                email : loginInputs[0].value,
                password: loginInputs[1].value
            },
            'login'
        )
    }

}

function sendData(userData, action){
  if(action === 'register'){      // if action is register set the needed properties of the form data
    const formData = new FormData()
    formData.append("username", userData.username)
    formData.append("email", userData.email)
    formData.append("phone", userData.phone)
    formData.append("password", userData.password)
    fetch('includes/registerformhandler.inc.php', {
        method: 'POST',
        body: formData
    })
    .then(resp => resp.text())        // send the data for processing, empty the form and redirect to profile if response is ok
    .then(data => {
        Array.from(registerInputs).forEach(input => input.value = '')
        window.location.href = "profile.php"
    })
    .catch(err => alert(err))
  }else if(action === 'login'){
    const formData = new FormData()
    formData.append("email", userData.email)
    formData.append("password", userData.password)
    fetch('includes/loginformhandler.inc.php', {
        method: 'POST',
        body: formData
    })
    .then(resp => resp.text())
    .then(data => {
        Array.from(registerInputs).forEach(input => input.value = '')
        window.location.href = "profile.php"
    })
    .catch(err => console.log(err))
  }
}

function checkForEmptyInputs(inputs){
    let errors = {}
    Array.from(inputs).forEach(input => {  // llok for empty inputs and attach errors to errors object if there are any 
        if(input.value === ''){
            errors[input.id] = input.id === 'phone' 
            ? `Please fill the required field for phone number!` 
            : `Please fill the required field for ${input.id}!` 
        }
    })
    return errors
}

export const onChangeSubmit = (e) => {
    e.preventDefault()
    let errors = {}
    if(e.target.id === 'change-username-form'){
        let [currentUsernameInput, newUsernameInput] = [document.querySelector('#current-username'), document.querySelector('#new-username')]
         errors = {...checkForEmptyInputs([currentUsernameInput, newUsernameInput])}
        if(Object.values(errors).every(val => val === null)){
           errors = {...inputsValidator([currentUsernameInput, newUsernameInput], errors)}
        }
        if(Object.values(errors).some(val => val !== null)){
            visualizeErrors(errors, 'change')
        }else{
            sendChangeData('change-username', {
                currentUsername: currentUsernameInput.value,
                newUsername: newUsernameInput.value
            })
        }
    }else if(e.target.id === 'change-email-form'){
        let [currentEmailInput, newEmailInput] = [document.querySelector('#current-email'), document.querySelector('#new-email')]
         errors = {...checkForEmptyInputs([currentEmailInput, newEmailInput])}
        if(Object.values(errors).every(val => val === null)){
             errors = {...inputsValidator([currentEmailInput, newEmailInput], errors)}
        }
        if(Object.values(errors).some(val => val !== null)){
            visualizeErrors(errors, 'change')
        }else{
            sendChangeData('change-email', {
                currentEmail: currentEmailInput.value,
                newEmail: newEmailInput.value
            })
        }
    }else if(e.target.id === 'change-phone-form'){
        let [currentPhoneInput, newPhoneInput] = [document.querySelector('#current-phone'), document.querySelector('#new-phone')]
         errors = {...checkForEmptyInputs([currentPhoneInput, newPhoneInput])}
        if(Object.values(errors).every(val => val === null)){
             errors = {...inputsValidator([currentPhoneInput, newPhoneInput], errors)}
        }
        if(Object.values(errors).some(val => val !== null)){
            visualizeErrors(errors, 'change')
        }else{
            sendChangeData('change-phone', {
                currentPhone: currentPhoneInput.value,
                newPhone: newPhoneInput.value
            })
        }
    }else if(e.target.id === 'change-password-form'){
        let [currentPasswordInput, newPasswordInput] = [document.querySelector('#current-password'), document.querySelector('#new-password')]
         errors = {...checkForEmptyInputs([currentPasswordInput, newPasswordInput])}
        if(Object.values(errors).every(val => val === null)){
             errors = {...inputsValidator([currentPasswordInput, newPasswordInput], errors)}
        }
        if(Object.values(errors).some(val => val !== null)){
            visualizeErrors(errors, 'change')
        }else{
            sendChangeData('change-password', {
                currentPassword: currentPasswordInput.value,
                newPassword: newPasswordInput.value
            })
        }
    }
}


function sendChangeData(action, inputs){
    console.log(inputs)
    let formData = new FormData()
    if(action === 'change-username'){
        formData.append('action', 'changeUsername')
        formData.append('currentUsername', inputs.currentUsername)
        formData.append('newUsername', inputs.newUsername)
    }else if(action === 'change-email'){
        formData.append('action', 'changeEmail')
        formData.append('currentEmail', inputs.currentEmail)
        formData.append('newEmail', inputs.newEmail)
    }else if(action === 'change-phone'){
        formData.append('action', 'changePhone')
        formData.append('currentPhone', inputs.currentPhone)
        formData.append('newPhone', inputs.newPhone)
    }else if(action === 'change-password'){
        formData.append('action', 'changePassword')
        formData.append('currentPassword', inputs.currentPassword)
        formData.append('newPassword', inputs.newPassword)
    }

    fetch('includes/changeinfohandler.inc.php', {
        method: 'POST',
        body: formData
    })
    .then((resp) => {
        return resp.text()
    })
    .then((data) => {
        if(!data.includes('Error')){
            window.location.href = 'profile.php'
        }
        alert(`${data}`)
    })
    .catch(err => alert(`${err}`))
}

function inputsValidator(inputs, errors){
    Array.from(inputs).forEach(input => {
        let value = input.value
        if(input.id === 'username' || input.id === 'current-username' || input.id === 'new-username'){
           errors[input.id] = value.length < 5 ? 'Username should be at least 5 characters long!' : null
        }
        if(input.id === 'email' || input.id === 'current-email' || input.id === 'new-email'){
            errors[input.id] = value.length < 10 && !value.split('').includes('@')
            ? 'Please enter a valid email !'
            : null
         }
         if(input.id === 'phone' || input.id === 'current-phone' || input.id === 'new-phone'){
            errors[input.id] = value.length < 5 
            ? 'Phone number should be at least 5 characters long!' 
            : value.split('').some(char => isNaN(char))
                ? "Phone number shouldn\'t contain letters!"
                : null
         }
         if(input.id === 'password' || input.id === 'current-password' || input.id === 'new-password'){
            errors[input.id] = value.length < 6 
            ? 'Password should be at least 6 characters long!' 
            : passwordValRegex.test(value)
                ? null
                : 'Password should contain at least one letter and one number!'
         }
    })
    return errors
}

function visualizeErrors(errors, action){
    Object.entries(errors).forEach(([key, val]) => {
        if(val !== null){
            let errorSpan = action === 'login'
            ? document.getElementById(`${key}-login-error`)
            : action === 'change'
                ? document.getElementById(`${key.split('-')[1]}-${key.split('-')[0]}-error`)
                : document.getElementById(`${key}-error`)
            errorSpan.style.display = 'block'
            errorSpan.textContent = val
        }
    })
}