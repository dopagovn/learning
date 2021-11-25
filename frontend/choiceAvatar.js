const btnCameraElement = document.querySelector('#avatar .btn-camera');
const inputFileElement = document.querySelector('#select-file');
const btnSubmitFileElement = document.querySelector('#submit-file');
const imageAvatarElement = document.querySelector('#avatar__img');


btnCameraElement.addEventListener('click', () => {
    inputFileElement.click();  
});

var fr = new FileReader();
fr.onload = () => {
    imageAvatarElement.src = fr.result;
}

inputFileElement.addEventListener('change', () => { 
    fr.readAsDataURL(inputFileElement.files[0]);
})

