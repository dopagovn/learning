const btnSendAgainElement = document.querySelector('.active .send-again');
const waitElement = document.querySelector('.wait');
const secondElement = document.querySelector('.wait > span');

if(countDown >= 0){
    btnSendAgainElement.style.display = 'none';
    waitElement.style.display = 'block';
    secondElement.textContent = countDown;
}
var cd = setInterval(() => {
    countDown--;
    secondElement.textContent = countDown;
    if(countDown < 0){
        btnSendAgainElement.style.display = 'block';
        waitElement.style.display = 'none';
        clearInterval(cd);
    }
},1000);

window.addEventListener('load', () => {
    const xhttp = new XMLHttpRequest();
    xhttp.open('POST', 'activePage.php');
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('sendMail=true');
});

const inputActiveCode = document.querySelector('input[name="activeCode"]');

inputActiveCode.addEventListener('input', () => {
    const errorElements = document.querySelectorAll('.error');
    errorElements.forEach((e) => {
        e.remove();
    });
});

