const letters_elm = document.querySelectorAll('svg path');

letters_elm.forEach((value) => {
    console.log(value.getTotalLength());
});