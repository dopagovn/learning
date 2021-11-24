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

const slideBarElement = document.querySelector('.chat-area__intro .slider-bar ');
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

const inputChatElement = document.querySelector('.chat-area__main .area-send .area-send__input > input');

function choiceFastChat(){
    if(messageAreaElement){

        const fastChatElements = document.querySelectorAll('.chat-area__main .area-send .area-send__toolbar > .fast-menu > .fast-menu__main > p');
        fastChatElements.forEach((e) => {
            e.addEventListener('click', () => {
                inputChatElement.value = e.textContent;
            });
        });
    }
}

window.addEventListener('load', choiceFastChat);

const iconEnterChatElement = document.querySelector('.chat-area__main .area-send .area-send__input .symbol-bar > i:first-child');

setInterval(() => {
    if(inputChatElement.value != ''){
        iconEnterChatElement.style.display = 'block';
    }
    else{
        iconEnterChatElement.style.display = 'none';
    }
}, 250);



// Ajax
// Conversation Click
const conversationElements = document.querySelectorAll('.list-conversation .conversations .conversations__main .conversation-item');
const introElement = document.querySelector('.chat-area__intro');
const chatmainElement = document.querySelector('.chat-area__main');
const areaMessageElement = document.querySelector('.chat-area__main .area-message');
const areaInfoElement = document.querySelector('.chat-area__main .partner-info');
const contentConversationElements = document.querySelectorAll('.conversation-item .conversation-item__content > .content');
const timeConversationElements = document.querySelectorAll('.conversation-item .conversation-item__time');

var messages;
var currentConversation = -1;
var beforeMessages;

setInterval(() => {
    var ajax = new XMLHttpRequest();
    ajax.open('POST', 'messages.php', true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(`CheckConversation=true`);
    ajax.onload = () => {
        messages = JSON.parse(ajax.responseText);
        contentConversationElements.forEach((e, idx) => {
            let mes = document.createElement('div');        
            mes.innerHTML = messages[idx];
            let name = mes.querySelector('.area-message__message:last-child .content .content__name');
            let content = mes.querySelector('.area-message__message:last-child .content .content__message');
            let time = mes.querySelector('.area-message__message:last-child .content .content__time');
            if(name && content && time){           
                e.textContent = name.textContent + ': ' + content.textContent;
                timeConversationElements[idx].textContent = time.textContent;
            }
            else{
                e.textContent = 'Chưa có tin nhắn';
                timeConversationElements[idx].textContent = '';
            }
        });
        if(currentConversation != -1){
            if(messageAreaElement){
                let lastMessage = conversationElements[currentConversation].querySelector('.conversation-item__content > .content').textContent;
                if(!beforeMessages){
                    beforeMessages = lastMessage;
                }
                else if(beforeMessages != lastMessage){
                    areaMessageElement.innerHTML = messages[currentConversation];
                    beforeMessages = lastMessage;
                    messageAreaElement.scrollTop = 100000;
                }
            }
        }      
    }
}, 1000);


conversationElements.forEach((e, idx) => {
    e.addEventListener('click', () => {
        introElement.style.display = 'none';
        chatmainElement.style.display = 'flex';
        areaMessageElement.innerHTML = messages[idx];

        const namePaticipantElement = document.querySelector('.chat-area__main .partner-info .info .info__content > .name');
        namePaticipantElement.textContent = e.querySelector('.conversation-item__content > .title').textContent;
        
        if(messageAreaElement){
            messageAreaElement.scrollTop = 100000;
        } 

        currentConversation = idx;
        let ajax = new XMLHttpRequest();
        ajax.open('POST', 'messages.php');
        ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        ajax.send('ConversationChosen=' + e.querySelector("input[name='idConversation']").value);
    });
});

function enterChat(){
    let ajax = new XMLHttpRequest();
    ajax.open('POST', 'messages.php');
    ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    ajax.send('sendMessage=' + inputChatElement.value);
    ajax.onload = () => {
        console.log(ajax.responseText);
    }
    inputChatElement.value = '';
}

iconEnterChatElement.addEventListener('click', enterChat);
inputChatElement.addEventListener('keydown', (e) => {
    if(e.key == 'Enter'){
        enterChat();
    }
});


// const friendsElenment = document.querySelector('#Friends');

// window.addEventListener('load', () => {
//     friendsElenment.style.maxHeight = window.innerHeight - (window.innerHeight * 0.09) + 'px';
// });
// window.addEventListener('resize', () => {
//     friendsElenment.style.maxHeight = window.innerHeight - (window.innerHeight * 0.09) + 'px';
// });