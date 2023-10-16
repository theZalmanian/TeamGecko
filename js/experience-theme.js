// fields
let switches; 
let themeButton; 
let formContainer; 
let question1; 
let formButton;
let starsRadio; 
let textInputBox;
let infoBox; 
let optionalQuestion;

window.onload = startApp; 


function startApp() {
    formButton = document.querySelector('#btn');
    themeButton = document.querySelector('#theme-button');
    themeButton.addEventListener("click", changeTheme);
    btn.addEventListener("click", noInputCheck);
}



function changeTheme() { 
    infoBox = document.querySelector("#info-form");
    optionalQuestion = document.querySelectorAll("#question-textarea");
    textInputBox = document.querySelector('.text-input');
    formContainer = document.querySelector('#main-container');
    formContainer.classList.toggle("dark-mode");
    textInputBox.classList.toggle("text-dark-mode");
    infoBox.classList.toggle("info-dark-mode");
    optionalQuestion.classList.toggle("textarea-dark-mode");

}

function noInputCheck() {
    question1 = document.querySelector('#question-1');
    if (question1.value === '')
    {
        question1.setAttribute('class', 'no-input');
    }
    else {
        question1.setAttribute('class', 'text-input');
    }
}