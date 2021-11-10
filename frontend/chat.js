function openTab(evt, tabName){
    var i, tabcontent, links;

    tabcontent = document.getElementsByClassName("tabcontent");
    for(i = 0; i < tabcontent.length; i++){
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("links");
    for(i = 0; i < tablinks.length; i++){
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " Chat";
}

const glassElement = document.querySelector('.glass');
const dashboardElement = document.querySelector('.dashboard');
const listConversationElement = document.querySelector('.list-conversation');

const slideBarElement = document.querySelector('.chat-area__intro .slider-bar');
const slideElements = document.querySelectorAll('.slider-bar .slider-bar__slides > .slide');
const inputSlideElements = document.querySelectorAll('.slider-bar .slider-bar__slides > input[name="slidebar"]');

function checkExist(){
    if(listConversationElement && slideBarElement && slideElements && inputSlideElements){
        return true;
    }
    return false;
}

function setWidthOfSlides(){
    if(!checkExist()){
        return;
    }
    let widthSlide = glassElement.clientWidth - dashboardElement.clientWidth - listConversationElement.clientWidth - 60;
    
    slideBarElement.style.maxWidth = widthSlide + 'px';
    slideElements.forEach((e) => {
        e.style.minWidth = widthSlide + 'px';
    });
    console.log(widthSlide);
}

window.addEventListener('load', setWidthOfSlides);
window.addEventListener('resize', setWidthOfSlides);

setInterval(() => {
    if(!checkExist()){
        return;
    }
    let cur = 1;
    inputSlideElements.forEach((e) => {
        if(e.checked){
            cur = e.attributes.value.value;
        }
    });

    if(cur < inputSlideElements.length){
        inputSlideElements[cur].checked = true;
    }
    else{
        inputSlideElements[0].checked = true;
    }
},7000);

const chatElement = document.querySelector('#Chat');

window.addEventListener('load', () => {
    chatElement.style.maxHeight = window.innerHeight - (window.innerHeight * 0.09) + 'px';
});
window.addEventListener('resize', () => {
    chatElement.style.maxHeight = window.innerHeight - (window.innerHeight * 0.09) + 'px';
});

const messageAreaElement = document.querySelector('.chat-area__main .area-message');

window.addEventListener('load', () => {
    if(messageAreaElement){
        messageAreaElement.scrollTop = 100000;
    }   
});

function choiceFastChat(){
    if(messageAreaElement){
        const inputChatElement = document.querySelector('.chat-area__main .area-send .area-send__input > input');
        const fastChatElements = document.querySelectorAll('.chat-area__main .area-send .area-send__toolbar > .fast-menu > .fast-menu__main > p');
        fastChatElements.forEach((e) => {
            e.addEventListener('click', () => {
                inputChatElement.value = e.textContent;
            });
        });
    }
}
window.addEventListener('load', choiceFastChat);