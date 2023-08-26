let profOptionsBtn = document.getElementById('prof-options-btn')
let optionBtns = document.querySelectorAll('.option-btn')
import { onChangeSubmit } from "./validators.js"


if(profOptionsBtn !== null){
    profOptionsBtn.addEventListener('click', () => {
        window.location.href = 'profileOptions.php'
    })
}


if(optionBtns !== null){
    Array.from(optionBtns).forEach(btn => {
        btn.addEventListener('click', (e) => changeOptionForm(e.target.id))
    })

    function changeOptionForm(option){
        let formData = new FormData()
        formData.append('option', option)
        fetch('profileOptions.php', {
            method: 'POST',
            body: formData
        }).then((response) => {
            if(!response.ok){
                throw new Error('Changing options failed.')
            }
            return response.json()
        }).then((data) => {
            document.querySelector('.forms').innerHTML = data.form
            document.querySelector('.forms > form').addEventListener('submit', (e) => onChangeSubmit(e))
        }).catch(err => {
            console.log(err)
        })
    }
}
