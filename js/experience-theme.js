// fields
let switches; 
let themeButton; 
let formContainer; 
window.onload = startApp; 


function startApp() {
    themeButton = document.querySelector('#theme-button');
    themeButton.addEventListener("click", changeTheme); 

}



function changeTheme() { 
    formContainer = document.querySelector('#form-container');
    formContainer.classList.toggle("dark-mode");
}