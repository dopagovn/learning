const monthsElement = document.querySelector('.register__row .birthday .date-picker .date-picker__main > .months');
const yearsElement = document.querySelector('.register__row .birthday .date-picker .date-picker__main > .years');
const daysElement = document.querySelector('.register__row .birthday .date-picker .date-picker__main > .days');
const datesElement = document.querySelector('.register__row .birthday .date-picker .date-picker__main > .dates');
const monthElement = document.querySelector('.register__row .birthday .date-picker .date-picker__choice .month-year > p:first-child > span');
const MonthElement = document.querySelector('.register__row .birthday .date-picker .date-picker__choice .month-year > p:first-child');
const yearElement = document.querySelector('.register__row .birthday .date-picker .date-picker__choice .month-year > p:last-child');
const reduceElement = document.querySelector('.register__row .birthday .date-picker .date-picker__choice .left-arrow');
const increseElement = document.querySelector('.register__row .birthday .date-picker .date-picker__choice .right-arrow');
const datePickerElement = document.querySelector('.register__row .birthday .date-picker');
const btnDatePickerElement = document.querySelector('.register .register__row .birthday > .birthday__calendar');
const inputBirthDay = document.querySelector('.register .register__row .birthday > input');

let currentYear = 1900;
let currentMonth = 1;
let currentTotalDateOfMonth;
const choiceDate = 'date';
const choiceMonth = 'month';
const choiceYear = 'year';
let currentChoice = choiceYear;
let currentDate = 1;

function initDateMonthYear() {
    for (let i = 1900; i < 1912; i++) {
        let year = `<p>${i}</p>`;
        yearsElement.innerHTML += year;
    }
    updateEventYears();
    for (let i = 1; i <= 12; i++) {
        let month = `<p>Tháng <span>${i}</span></p>`;
        monthsElement.innerHTML += month;
    }
    updateEventMonths();

    updateDates();
}
function updateEventYears() {
    let yearsElements = document.querySelectorAll('.register__row .birthday .date-picker .date-picker__main > .years p');
    for (let i = 0; i < 12; i++) {
        yearsElements[i].addEventListener('click', (e) => {
            currentYear = e.target.textContent;
            yearElement.textContent = currentYear;
            currentChoice = choiceMonth;
            monthsElement.style.display = 'flex';
            yearsElement.style.display = 'none';
        });
    }
}
function updateEventMonths() {
    let monthsElements = document.querySelectorAll('.register__row .birthday .date-picker .date-picker__main > .months p');
    for (let i = 0; i < 12; i++) {
        monthsElements[i].addEventListener('click', (e) => {
            currentMonth = e.target.lastChild.textContent;
            monthElement.textContent = currentMonth;
            currentChoice = choiceDate;
            monthsElement.style.display = 'none';
            daysElement.style.display = 'flex';
            datesElement.style.display = 'block';
            updateDates();
        });
    }
}
function getTotalDateOfMonth(month, year) {
    if (month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12) {
        return 31;
    }
    else if (month == 2 && year % 4 != 0) {
        return 28;
    }
    else if (month == 2 && year % 4 == 0) {
        return 29;
    }
    else {
        return 30;
    }
}
function updateDates() {
    let dayOfFirstDateOfMonth = (new Date(currentYear, currentMonth - 1, 1)).getDay();
    currentTotalDateOfMonth = getTotalDateOfMonth(currentMonth, currentYear);
    let totalDateOfMonthBefore;
    if (currentMonth === 1) {
        totalDateOfMonthBefore = getTotalDateOfMonth(12, currentYear - 1);
    }
    else if (currentMonth === 12) {
        totalDateOfMonthBefore = getTotalDateOfMonth(11, currentYear);
    }
    else {
        totalDateOfMonthBefore = getTotalDateOfMonth(currentMonth - 1, currentYear);
    }
    let day = 1;
    let row = 1;
    datesElement.innerHTML = '<div class="dates__row"></div>';
    let rowElm = document.querySelector('.register__row .birthday .date-picker .date-picker__main > .dates > .dates__row:nth-child(1)');
    for (let i = 0; i < dayOfFirstDateOfMonth; i++) {
        rowElm.innerHTML += `<p style="opacity: .6;">${totalDateOfMonthBefore - dayOfFirstDateOfMonth + i + 1}</p>`;
        day++;
    }

    for (let i = 1; i <= currentTotalDateOfMonth; i++) {
        rowElm.innerHTML += `<p>${i}</p>`;
        day++;
        if (day > 7) {
            day = 1;
            row++;
            datesElement.innerHTML += '<div class="dates__row"></div>';
            rowElm = document.querySelector(`.register__row .birthday .date-picker .date-picker__main > .dates > .dates__row:nth-child(${row})`);
        }
    }
    let j = 1;
    for (let i = rowElm.children.length; i < 7; i++) {
        rowElm.innerHTML += `<p style="opacity: .6;">${j}</p>`;
        j++;
    }
    updateEventDates();
}

function updateEventDates(elm) {
    let rowElms = document.querySelectorAll('.register__row .birthday .date-picker .date-picker__main > .dates .dates__row');
    let checkDateBefore = true;
    let checkDateAfter = false;
    for(let i = 1; i <= rowElms.length; i++){
        for(let j = 1; j <= 7; j++){
            let dateElm = document.querySelector(`.register__row .birthday .date-picker .date-picker__main > .dates .dates__row:nth-child(${i}) > p:nth-child(${j})`);           
            if(dateElm.textContent != 1 && checkDateBefore){
                dateElm.addEventListener('click', () => {
                    if(currentMonth == 1){
                        currentMonth = 12;
                        currentYear --;
                    }
                    else{                      
                        currentMonth --;
                    }
                    inputBirthDay.value = `${dateElm.textContent}/${currentMonth}/${currentYear}`;
                    monthElement.textContent = currentMonth;   
                    yearElement.textContent = currentYear;  
                    datePickerElement.style.display = 'none';           
                });
            }
            else{
                checkDateBefore = false;
            }
            if(!checkDateBefore && !checkDateAfter){
                dateElm.addEventListener('click', () => {
                    inputBirthDay.value = `${dateElm.textContent}/${currentMonth}/${currentYear}`; 
                    datePickerElement.style.display = 'none';                   
                });
                if(dateElm.textContent == getTotalDateOfMonth(currentMonth, currentYear)){
                    checkDateAfter = true;
                }               
            }
            else if(checkDateAfter){
                dateElm.addEventListener('click', () => {
                    if(currentMonth == 12){
                        currentMonth = 1;
                        currentYear ++;
                    }
                    else{
                        currentMonth++;
                    }
                    inputBirthDay.value = `${dateElm.textContent}/${currentMonth}/${currentYear}`;
                    monthElement.textContent = currentMonth;   
                    yearElement.textContent = currentYear;  
                    datePickerElement.style.display = 'none';             
                });
            }
        }
    }
}

reduceElement.addEventListener('click', () => {
    if (currentChoice == choiceYear) {
        let yearElement = document.querySelector('.register__row .birthday .date-picker .date-picker__main > .years p:last-child');
        let year = yearElement.textContent;
        if (year != '1911') {
            yearsElement.innerHTML = '';
            year -= 23;
            for (let i = 1; i <= 12; i++) {
                let yearElm = `<p>${year++}</p>`;
                yearsElement.innerHTML += yearElm;
            }
            updateEventYears();
        }
    }
    else {
        if (monthElement.textContent == 1) {
            currentMonth = 12;
            currentYear--;
            monthElement.textContent = currentMonth;
            yearElement.textContent = currentYear;
        }
        else {
            currentMonth--;
            monthElement.textContent = currentMonth;
        }
        updateDates();
    }
});
increseElement.addEventListener('click', () => {
    if (currentChoice == choiceYear) {
        let yearElement = document.querySelector('.register__row .birthday .date-picker .date-picker__main > .years p:last-child');
        let year = yearElement.textContent;
        if (year != '2103') {
            yearsElement.innerHTML = '';
            year++;
            for (let i = 1; i <= 12; i++) {
                let yearElm = `<p>${year++}</p>`;
                yearsElement.innerHTML += yearElm;
            }
            updateEventYears();
        }
    }
    else {
        if (monthElement.textContent == 12) {
            currentMonth = 1;
            currentYear++;
            monthElement.textContent = currentMonth;
            yearElement.textContent = currentYear;
        }
        else {
            currentMonth++;
            monthElement.textContent = currentMonth;
        }
        updateDates();
    }
});
MonthElement.addEventListener('click', () => {
    daysElement.style.display = 'none';
    datesElement.style.display = 'none';
    yearsElement.style.display = 'none';
    monthsElement.style.display = 'flex';
    currentChoice = choiceMonth;
});
yearElement.addEventListener('click', () => {
    daysElement.style.display = 'none';
    datesElement.style.display = 'none';
    monthsElement.style.display = 'none';
    yearsElement.style.display = 'flex';
    currentChoice = choiceYear;
});

initDateMonthYear();

inputBirthDay.addEventListener('keydown', (e) => {
    if (e.key != 'F5') {
        e.preventDefault();
    }
});

btnDatePickerElement.addEventListener('click', (e) => {
    e.stopPropagation();
    if (datePickerElement.style.display == 'none') {
        datePickerElement.style.display = 'block';
    }
    else {
        datePickerElement.style.display = 'none';
    }
});

document.addEventListener('click', (e) => {
    if (!datePickerElement.contains(e.target)) {
        datePickerElement.style.display = 'none';
    }
});

// validation

const lastNameInputElement = document.querySelector('input[name="lastName"]');
const firstNameInputElement = document.querySelector('input[name="firstName"]');;
const emailInputElement = document.querySelector('input[name="email"]');;
const passwordInputElement = document.querySelector('input[name="password"]');;
const repeatPasswordInputElement = document.querySelector('input[name="repeatPassword"]');;
const btnAgreePolicyElement = document.querySelector('input[name="agreePolicy"]');
const btnRegisterElement = document.querySelector('button[name="register"]');
const phoneInputElement = document.querySelector('input[name="phone"]');

function onInput(e, error){
    let element = e.target;
    if(element.value == ""){
        if(element.nextElementSibling == null){
            element.insertAdjacentHTML('afterend', `<p class="error">${error}</p>`);
        }
    }
    else{
        if(element.nextElementSibling){
            element.nextElementSibling.remove();
        }       
    }
}

function onFocusOut(e, error){
    let element = e.target;
    if(element.value == ""){
        if(element.nextElementSibling == null){
            element.insertAdjacentHTML('afterend', `<p class="error">${error}</p>`)
        }
    }
}

function emailFocusOutValidation(){
    let ex = /^[\w]+@[a-zA-Z0-9]{3,5}\.[a-zA-Z0-9]{2,5}(\.[a-zA-Z0-9]{2,5})?$/; 
    let regEx = new RegExp(ex);
    if(emailInputElement.value != ""){
        if(!regEx.test(emailInputElement.value)){
            if(emailInputElement.nextElementSibling == null){
                emailInputElement.insertAdjacentHTML('afterend', '<p class="error">Email không hợp lệ</p>')
            }
        }
    }
}

lastNameInputElement.addEventListener('input', (e) => onInput(e, 'Hãy nhập họ'));
lastNameInputElement.addEventListener('focusout', (e) => onFocusOut(e, 'Hãy nhập họ'));

firstNameInputElement.addEventListener('input', (e) => onInput(e, 'Hãy nhập tên'));
firstNameInputElement.addEventListener('focusout', (e) => onFocusOut(e, 'Hãy nhập tên'));

emailInputElement.addEventListener('input', (e) => onInput(e, 'Hãy nhập email'));
emailInputElement.addEventListener('focusout', (e) => {onFocusOut(e, 'Hãy nhập email'), emailFocusOutValidation()});

passwordInputElement.addEventListener('input', (e) => onInput(e, 'Hãy nhập mật khẩu'));
passwordInputElement.addEventListener('focusout', (e) => onFocusOut(e, 'Hãy nhập mật khẩu'));

repeatPasswordInputElement.addEventListener('input', (e) => onInput(e, 'Hãy nhập lại mật khẩu'));
repeatPasswordInputElement.addEventListener('focusout', (e) => onFocusOut(e, 'Hãy nhập lại mật khẩu'));

btnAgreePolicyElement.addEventListener('click', () => {
    if(btnRegisterElement.nextElementSibling){
        btnRegisterElement.nextElementSibling.remove();
    }
});

phoneInputElement.addEventListener('keydown', (e) => {
    let ex = /[0-9]$/;
    let RegEx = new RegExp(ex);
    if(!RegEx.test(e.key) && e.key != 'Backspace'){
        e.preventDefault();
    }
});

phoneInputElement.addEventListener('focus', () => {
    if(phoneInputElement.nextElementSibling != null){
        phoneInputElement.nextElementSibling.remove();
    }
})

phoneInputElement.addEventListener('focusout', () => {
    let ex = /^[0-9]{10,13}$/;
    let RegEx = new RegExp(ex);
    if(!RegEx.test(phoneInputElement.value) && phoneInputElement.value != ''){
        if(phoneInputElement.nextElementSibling == null){
            phoneInputElement.insertAdjacentHTML('afterend', '<p class="error">Số điện thoại từ 10->13 chữ số</p>');
        }
    }
});
