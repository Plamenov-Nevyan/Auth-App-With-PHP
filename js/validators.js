
let registerInputs = document.querySelectorAll('.register-input')
let loginInputs = document.querySelectorAll('.login-input')
let registerForm = document.getElementById('register-form')
let loginForm = document.getElementById('login-form')
let emailValRegex = /^[\w\.]+@([\w-]+\.)+[\w-]{2,4}$/g
let passwordValRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/
if(registerForm !== null){
    registerForm.addEventListener('submit', (e) => validateRegisterForm(e))
}
if(loginForm !== null){
    loginForm.addEventListener('submit', (e) => validateLoginForm(e))
}

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
    let errors = checkForEmptyInputs(registerInputs)
    if(Object.values(errors).every(val => val === null)){
        Array.from(registerInputs).forEach(input => {
            let value = input.value
            if(input.id === 'username'){
               errors[input.id] = value.length < 5 ? 'Username should be at least 5 characters long!' : null
            }
            if(input.id === 'email'){
                errors[input.id] = value.length < 10 && !value.split('').includes('@')
                ? 'Please enter a valid email !'
                : null
             }
             if(input.id === 'phone'){
                errors[input.id] = value.length < 5 
                ? 'Phone number should be at least 5 characters long!' 
                : value.split('').some(char => isNaN(char))
                    ? "Phone number shouldn\'t contain letters!"
                    : null
             }
             if(input.id === 'password'){
                errors[input.id] = value.length < 6 
                ? 'Password should be at least 6 characters long!' 
                : passwordValRegex.test(value)
                    ? null
                    : 'Password should contain at least one letter and one number!'
             }
        })
    }

    if(Object.values(errors).some(val => val !== null)){
        Object.entries(errors).forEach(([key, val]) => {
            if(val !== null){
                let errorSpan = document.getElementById(`${key}-error`)
                errorSpan.style.display = 'block'
                errorSpan.textContent = val
            }
        })
    }else{
        sendData(
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
    let errors = checkForEmptyInputs(loginInputs)
    if(Object.values(errors).every(val => val === null)){
        Array.from(loginInputs).forEach(input => {
            let value = input.value
            if(input.id === 'email'){
                errors[input.id] = value.length < 10 && !value.split('').includes('@')
                ? 'Please enter a valid email !'
                : null
             }
             if(input.id === 'password'){
                errors[input.id] = value.length < 6 
                ? 'Password should be at least 6 characters long!' 
                : passwordValRegex.test(value)
                    ? null
                    : 'Password should contain at least one letter and one number!'
             }
        })
    }
    if(Object.values(errors).some(val => val !== null)){
        Object.entries(errors).forEach(([key, val]) => {
            if(val !== null){
                let errorSpan = document.getElementById(`${key}-login-error`)
                errorSpan.style.display = 'block'
                errorSpan.textContent = val
            }
        })
    }else{
        sendData(
            {
                email : loginInputs[0].value,
                password: loginInputs[1].value
            },
            'login'
        )
    }

}

function sendData(userData, action){
  if(action === 'register'){
    const formData = new FormData()
    formData.append("username", userData.username)
    formData.append("email", userData.email)
    formData.append("phone", userData.phone)
    formData.append("password", userData.password)
    fetch('includes/registerformhandler.inc.php', {
        method: 'POST',
        body: formData
    })
    .then(resp => resp.text())
    .then(data => {
        Array.from(registerInputs).forEach(input => input.value = '')
        window.location.href = "profile.php"
    })
    .catch(err => console.log(err))
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
    errors = {}
    Array.from(inputs).forEach(input => {
        if(input.value === ''){
            errors[input.id] = input.id === 'phone' 
            ? `Please fill the required field for phone number!` 
            : `Please fill the required field for ${input.id}!` 
        }
    })
    return errors
}

