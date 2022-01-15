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

const inputChatElement = document.querySelector('.chat-area__main .area-send .area-send__input > .area-send__input-text');

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

// Ajax
// Conversation Click
const conversationElements = document.querySelectorAll('.list-conversation .conversations .conversations__main .conversation-item');
const contentConversationElements = document.querySelectorAll('.conversation-item .conversation-item__content > .content');
const timeConversationElements = document.querySelectorAll('.conversation-item .conversation-item__time');
const introElement = document.querySelector('.chat-area__intro');
const chatmainElement = document.querySelector('.chat-area__main');
const areaMessageElement = document.querySelector('.chat-area__main .area-message');
const areaInfoElement = document.querySelector('.chat-area__main .partner-info');

var conversations;
var currentConversation = -1;
var beforeMessages = [];
var newMessage = false;

setInterval(() => {
    var ajax = new XMLHttpRequest();
    ajax.open('POST', 'messages.php', true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(`ReloadMessages=true`);
    ajax.onload = () => {
        conversations = JSON.parse(ajax.responseText);
        // reload conversations
        contentConversationElements.forEach((e, idx) => {
            let mes = document.createElement('div');        
            mes.innerHTML = conversations[idx];
            // get last message
            let name = mes.querySelector('.area-message__message:last-child .content .content__name');
            let content = mes.querySelector('.area-message__message:last-child .content .content__message');
            let contentImg = mes.querySelector('.area-message__message:last-child .content .content__img');
            let contentFile = mes.querySelector('.area-message__message:last-child .content .content__download');
            let contentDelete = mes.querySelector('.area-message__message:last-child .content .content__message--delete');
            let time = mes.querySelector('.area-message__message:last-child .content .content__time');
            
            if(name && content && time && !contentDelete){           
                e.textContent = name.textContent + ': ' + content.textContent;
                timeConversationElements[idx].textContent = time.textContent;
            }
            else if(contentImg){
                e.textContent = name.textContent + ' đã gửi một ảnh';
                timeConversationElements[idx].textContent = time.textContent;
            }
            else if(contentFile){
                e.textContent = name.textContent + ' đã gửi một file';
                timeConversationElements[idx].textContent = time.textContent;
            }
            else if(contentDelete){
                e.textContent = name.textContent + ': ' + 'Đã xóa tin nhắn';
                timeConversationElements[idx].textContent = time.textContent;
            }           
            else{
                e.textContent = 'Chưa có tin nhắn';
                timeConversationElements[idx].textContent = '';
            }
        });

        // reload messages of conversationChosen
        if(currentConversation != -1){
            if(messageAreaElement){
                let lastMessage = conversations[currentConversation];
                if(!beforeMessages[currentConversation] && beforeMessages[currentConversation] != ''){
                    beforeMessages[currentConversation] = conversations[currentConversation];
                }
                else if(beforeMessages[currentConversation] != lastMessage){
                    areaMessageElement.innerHTML = conversations[currentConversation];
                    areaMessageElement.innerHTML += `
                        <div class='area-message__viewImage' style='display: none;'>                               
                            <img class='content__img' src='backend/message_file/56504108_1_5_Untitled123.png'>
                            <i class='fas fa-times'></i>
                        </div>
                    `;
                    initDeleteComponent();                   
                    beforeMessages[currentConversation] = lastMessage;                   
                    setTimeout(() => {
                        areaMessageElement.scrollTop = areaMessageElement.scrollHeight;
                    }, 100);                                                            
                }
            }
        }
    }
}, 1000);

conversationElements.forEach((e, idx) => {
    e.addEventListener('click', () => {
        introElement.style.display = 'none';
        chatmainElement.style.display = 'flex';
        areaMessageElement.innerHTML = conversations[idx];
        areaMessageElement.innerHTML += `
            <div class='area-message__viewImage' style='display: none;'>                               
                <img class='content__img' src=''>
                <i class='fas fa-times'></i>
            </div>
        `;

        const namePaticipantElement = document.querySelector('.chat-area__main .partner-info .info .info__content > .name');
        let avatarPaticipantElement = document.querySelector('.chat-area__main .partner-info .info > *:first-child');
        namePaticipantElement.textContent = e.querySelector('.conversation-item__content > .title').textContent;
        if(e.querySelector('.conversation-item__avatar')){
            avatarPaticipantElement.outerHTML = e.querySelector('.conversation-item__avatar').outerHTML;
        }
        else{
            avatarPaticipantElement.outerHTML = e.querySelector('.conversation-item__avatar-group').outerHTML;
        }
        
        
        if(messageAreaElement){
            areaMessageElement.scrollTop = areaMessageElement.scrollHeight;
        }

        currentConversation = idx;
        // fetch server currentConversation
        let ajax = new XMLHttpRequest();
        ajax.open('POST', 'messages.php');
        ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        ajax.send('ChooseConversation=' + e.querySelector("input[name='idConversation']").value);
        ajax.onload = () => {
            getStatus();
            initDeleteComponent();
        }
    });
});

// btn-image Click
const btnImageElement = document.querySelector('.chat-area__main .area-send .area-send__toolbar > .send-img');
const inputImageElement = document.querySelector('.chat-area__main .area-send .area-send__input > .area-send__input-image');
const viewFileElement = document.querySelector('.chat-area__main .area-send .area-send__fileView');
var imageFiles = [];

btnImageElement.addEventListener('click', () => {
    inputImageElement.click();
});

inputImageElement.addEventListener('input', ()=> {
    imageFiles.push(inputImageElement.files[0]);
    viewFileHTML = document.createElement('div');
    viewFileHTML.className = 'img';
    viewFileHTML.innerHTML = '<i class="far fa-times-circle"></i>';
    imgViewHTML = document.createElement('img');
    let fr = new FileReader();
    fr.readAsDataURL(inputImageElement.files[0]);
    fr.onload = () => {
        imgViewHTML.src = fr.result;
    }   
    viewFileHTML.insertAdjacentElement('beforeend', imgViewHTML);
    viewFileElement.appendChild(viewFileHTML);
    
    let btnCloseElement = viewFileHTML.querySelector('i');
    btnCloseElement.addEventListener('click', (e) => {
        let viewFileElements = viewFileElement.querySelectorAll('div');
        for(let i = 0; i < imageFiles.length; i++){
            viewFileElements[i].id = i;
        }

        let id = e.target.parentElement.id;
        e.target.parentElement.remove();
        imageFiles.splice(id, 1);
        console.log(id);
        console.log(imageFiles);              
    });
    // `
    //     <div class="img">
    //         <img src="frontend/img/user1.jpeg">
    //         <i class="far fa-times-circle"></i>
    //     </div>
    // `;
    inputImageElement.value = "";
});

function reloadContentImg(){
    const imgContentElements = document.querySelectorAll('.chat-area__main .area-message .area-message__message > .content > .content__img');
    if(imgContentElements){
        imgContentElements.forEach((e) => {
            e.onclick = function(ev){
                const viewImageElement = document.querySelector('.chat-area__main .area-message .area-message__viewImage');
                viewImageElement.style = 'display: flex;';
                const imageViewElement = document.querySelector('.chat-area__main .area-message .area-message__viewImage > img');
                imageViewElement.src = ev.target.src;
                const btnCloseViewElement = document.querySelector('.chat-area__main .area-message .area-message__viewImage > i');
                btnCloseViewElement.addEventListener('click' ,() => {
                    viewImageElement.style = 'display: none;';
                });
            }
        });     
    }   
}
setInterval(reloadContentImg, 1000);

// btn-file Click
const btnFileElement = document.querySelector('.chat-area__main .area-send .area-send__toolbar > .send-file');
const inputFileElement = document.querySelector('.chat-area__main .area-send .area-send__input > .area-send__input-file');

btnFileElement.addEventListener('click', () => {
    inputFileElement.click();
});
inputFileElement.addEventListener('input', () => {
    console.log('input');
    let formData = new FormData();
    formData.append('sendMessage', '');
    formData.append('sendFile0', inputFileElement.files[0]);
    let ajax = new XMLHttpRequest();
    ajax.open('POST', 'messages.php');
    ajax.send(formData);  
    ajax.onload = () => {
        newMessage = true;
        console.log(ajax.responseText);
    }

    inputFileElement.value = "";
});

// btnChat Click
const iconEnterChatElement = document.querySelector('.chat-area__main .area-send .area-send__input .symbol-bar > i:first-child');

setInterval(() => {
    if(inputChatElement.value != '' || imageFiles.length > 0){
        iconEnterChatElement.style.display = 'block';
    }
    else{
        iconEnterChatElement.style.display = 'none';
    }
}, 250);

function enterChat(){
    let formData = new FormData();
    formData.append('sendMessage', inputChatElement.value);
    if(imageFiles.length > 0){
        for(let i = 0; i < imageFiles.length; i++){
            formData.append('sendFile' + i, imageFiles[i]);
        }       
    }  
    let ajax = new XMLHttpRequest();
    ajax.open('POST', 'messages.php');
    ajax.send(formData);  
    ajax.onload = () => {
        newMessage = true;
        console.log(ajax.responseText);
    }

    // reset
    inputChatElement.value = '';
    imageFiles = [];
    viewFileElement.innerHTML = '';
}

iconEnterChatElement.addEventListener('click', enterChat);
inputChatElement.addEventListener('keydown', (e) => {
    if(e.key == 'Enter'){
        enterChat();
    }
});

// online ajax
setInterval(() => {
    let ajax = new XMLHttpRequest;
    ajax.open('POST', 'online.php');
    ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    ajax.send('updateOnline=true');
}, 1000);

// reload status paticipant

function getStatus(){
    const timePaticipantElement = document.querySelector('.chat-area__main .partner-info .info .info__content > .time');
    let ajax = new XMLHttpRequest();
    ajax.open('POST', 'online.php');
    ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    ajax.send('getStatusParticipant=true');
    ajax.onload = () => {
        console.log(ajax.responseText);
        let status = ajax.responseText;
        timePaticipantElement.textContent = status;
        const statusElement = document.querySelector('.chat-area__main .partner-info .info .info__status > span');
        const statusParentElement = document.querySelector('.chat-area__main .partner-info .info .info__status');
        if(status == 'Online'){
            statusElement.style.backgroundColor = '#00a170';
            statusParentElement.style.display = 'block';         
        }
        else if(status.includes('thành viên')){
            statusParentElement.style.display = 'none';
        }
        else{
            statusElement.style.backgroundColor = 'gray';
            statusParentElement.style.display = 'block';
        }
    }
}

setInterval(getStatus, 10000);

// delete message

function initDeleteComponent(){
    console.log('init delete');
    const btnShowMenuDeleteElements = document.querySelectorAll('.chat-area__main .area-message .area-message__message > .tool > .tool__btn');
    const menuDeleteElements = document.querySelectorAll('.chat-area__main .area-message .area-message__message > .tool > .tool__menu');
    const btnDeleteElements = document.querySelectorAll('.chat-area__main .area-message .area-message__message > .tool > .tool__menu > p:first-child');

    if(btnShowMenuDeleteElements && menuDeleteElements && btnDeleteElements){
        btnShowMenuDeleteElements.forEach((e, idx) => {
            e.addEventListener('click', (ev) => {
                ev.stopPropagation();
                if(menuDeleteElements[idx].style.display == 'block'){
                    menuDeleteElements[idx].style = 'display: none';
                }
                else{
                    menuDeleteElements[idx].style = 'display: block';
                }
            });
        });
        btnDeleteElements.forEach((e) => {
            e.addEventListener('click', () => {
                let idMessage = e.nextElementSibling.value;
                let ajax = new XMLHttpRequest();
                ajax.open('POST', 'messages.php');
                ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                ajax.send('deleteMessage='+idMessage);
                ajax.onload = () => {
                    console.log(ajax.responseText);
                }
            });
        });

        window.addEventListener('click', () => {
            menuDeleteElements.forEach((ev) => {
                ev.style = 'display: none';
            });
        });
    }
}

// like,icon btn click
const btnLikeElement = document.querySelector('.chat-area__main .area-send .area-send__input > .symbol-bar > .send-like');

btnLikeElement.addEventListener('click', () => {
    let ajax = new XMLHttpRequest();
    ajax.open('POST', 'messages.php');
    ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    ajax.send('sendIcon=likeIcon.gif');  
    ajax.onload = () => {
        console.log(ajax.responseText);
    }
});

const btnIconElements = document.querySelectorAll('.chat-area__main .area-send .area-send__input > .symbol-bar > .send-icon > .send-icon__menu > img');
console.log(btnIconElements);
btnIconElements.forEach((e) => {
    e.addEventListener('click', (ev) => {
        let nameIcon = ev.target.src;
        nameIcon = nameIcon.split('/');
        nameIcon = nameIcon[nameIcon.length - 1];
        let ajax = new XMLHttpRequest();
        ajax.open('POST', 'messages.php');
        ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        ajax.send('sendIcon=' + nameIcon);  
        ajax.onload = () => {
            console.log(ajax.responseText);
        }
    });
});

// group-chat click
const btnGroupShowElement = document.querySelector('.list-conversation .search-bar > .group-menu');
const groupElement = document.querySelector('.group-create__form');
const btnGroupCloseElement = document.querySelector('.group-create__form form > .title > i');
const btnGroupCancerElement = document.querySelector('.group-create__form form > .btns > p:first-child');
const btnCreateGroupElement = document.querySelector(".group-create__form form > .btns > input[type='submit']");
var listFriendSearchElements = undefined;

btnGroupShowElement.addEventListener('click', () => {
    groupElement.style = 'display: flex';

    let ajax = new XMLHttpRequest();
    ajax.open('POST', 'group.php');
    ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    ajax.send('getListFriend=true');  
    ajax.onload = () => {
        const listFriendElement = document.querySelector('.group-create__form form > .list-friend');
        listFriendElement.innerHTML = ajax.responseText;
        listFriendSearchElements = document.querySelectorAll('.group-create__form form > .list-friend > .list-friend__row');
        console.log(ajax.responseText);
    }
});

btnGroupCloseElement.addEventListener('click', () => {
    groupElement.style = 'display: none';
});
btnGroupCancerElement.addEventListener('click', () => {
    groupElement.style = 'display: none';
});

setInterval(() => {
    // validation btnCreateGroup
    const checkBoxFriendElements = document.querySelectorAll(".group-create__form form > .list-friend .list-friend__row > input[type='checkbox']"); 
    let sumCheckedFriend = 0;
    for(let i = 0; i < checkBoxFriendElements.length; i++){
        if(checkBoxFriendElements[i].checked){
            sumCheckedFriend++;           
        }
    }
    if(sumCheckedFriend >= 2){
        if(btnCreateGroupElement.classList.contains('disable')){
            btnCreateGroupElement.classList.remove('disable');
        }
        btnCreateGroupElement.disabled = false;
    }
    else{
        if(!btnCreateGroupElement.classList.contains('disable')){
            btnCreateGroupElement.classList.add('disable');
        }
        btnCreateGroupElement.disabled = true;
    }
    
}, 100);

const inputSearchFriendElement = document.querySelector('.group-create__form form > .add-people > input');

inputSearchFriendElement.addEventListener('input' ,() => {
    let searchKey = inputSearchFriendElement.value;
    let result = [];
    listFriendSearchElements.forEach((e) => {
        let nameFriend = e.querySelector('span').textContent;
        if(nameFriend.includes(searchKey)){
            result.push(e);
        }
    });

    const listFriendElement = document.querySelector('.group-create__form form > .list-friend');
    listFriendElement.innerHTML = '';
    result.forEach((e) => {
        listFriendElement.appendChild(e);
    });
});

// search friend to chat
const searchInputElement = document.querySelector('.list-conversation .search-bar > input');
const btnCloseSearchELement = document.querySelector('.list-conversation .search-bar > .close-search');
const conversationTitleElement = document.querySelector('.list-conversation .conversations .conversations__title');

searchInputElement.addEventListener('focus', () => {
    const conversationMainElement = document.querySelector('.list-conversation .conversations .conversations__main');
    const resultMainElement = document.querySelector('.list-conversation .search-bar__result');

    conversationMainElement.style = 'display: none;';
    resultMainElement.style = 'display: flex;';
    btnGroupShowElement.style = 'display: none';
    btnCloseSearchELement.style = 'display: flex';
    conversationTitleElement.innerHTML = '<span>Bạn bè<i class="fas fa-chevron-down" style="margin-left: 5px;"></i></span>';
    searchFriendToChat();  
});
function searchFriendToChat(){
    let keyword = searchInputElement.value;
    let ajax = new XMLHttpRequest();
    ajax.open('GET', `friends.php?search=true&keyword=${keyword}`);
    ajax.onload = () => {
        let result = JSON.parse(ajax.responseText);
        let html = '';
        result.forEach((friend) => {
            html += `
                <div class="result">
                    <img class="result__avatar" src="${friend.avatar}">
                    <div class="result__name">
                        <p class="name">${friend.LastName + ' ' + friend.FirstName}</p>
                        <p class="des">Bạn bè</p>
                    </div>
                    <button id="${friend.id}" type="button">Nhắn tin</button>
                </div>
            `;
        });
        const resultMainElement = document.querySelector('.list-conversation .search-bar__result');
        resultMainElement.innerHTML = html;
        // init button
        const btnCreateConversationElements = document.querySelectorAll('.list-conversation .search-bar__result > .result > button');
        btnCreateConversationElements.forEach((e) => {
            e.addEventListener('click', () => {
                let idFriend = e.id;
                ajax.open('POST', 'messages.php');
                ajax.setRequestHeader('Content-type','application/x-www-form-urlencoded');
                ajax.onload = () => {
                    // reload conversation
                    btnCloseSearchELement.click();
                    let result = JSON.parse(ajax.responseText);
                    if(result.type == 'exist'){
                        let idConversationNeedChoice = result.idConversation;
                        conversationElements.forEach((e) => {
                            let idConversation = e.querySelector("input[name='idConversation']").value;
                            if(idConversation == idConversationNeedChoice){
                                e.click();
                            }
                        });
                    }
                    else if(result.type == 'not exist'){
                        document.location = 'chat.php';
                    }
                }
                ajax.send('createConversation=' + idFriend);
            });
        });
    }
    ajax.send();
}
searchInputElement.addEventListener('input', () => {
    // send ajax 
    searchFriendToChat();
});
btnCloseSearchELement.addEventListener('click', () => {
    const conversationMainElement = document.querySelector('.list-conversation .conversations .conversations__main');
    const resultMainElement = document.querySelector('.list-conversation .search-bar__result');

    conversationMainElement.style = 'display: flex;';
    resultMainElement.style = 'display: none;';
    btnGroupShowElement.style = 'display: flex';
    btnCloseSearchELement.style = 'display: none';
    conversationTitleElement.innerHTML = '<span>Tất cả tin nhắn<i class="fas fa-chevron-down" style="margin-left: 5px;"></i></span>';
    searchInputElement.value = '';
});

// friend area
const friendElement = document.querySelector('#Friends');     

window.addEventListener('load', () => {
    friendElement.style.maxHeight = window.innerHeight - (window.innerHeight * 0.09) + 'px';
});
window.addEventListener('resize', () => {
    friendElement.style.maxHeight = window.innerHeight - (window.innerHeight * 0.09) + 'px';
});

/* Active button */
var btnContainer = document.getElementById("conversation");
var btns = document.getElementsByClassName("contact-list-item");

for (var i = 0; i < btns.length; i++){
    btns[i].addEventListener("click", function(){
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace("active","");
        this.className += " active";
    })
}