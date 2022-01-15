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
            let type = settingConfig.language;
            if(name && content && time && !contentDelete){              
                if(type == 'en'){
                    if(name.textContent == 'Bạn'){
                        name.textContent = 'You';
                    }
                }           
                e.textContent = name.textContent + ': ' + content.textContent;
                timeConversationElements[idx].textContent = time.textContent;
            }
            else if(contentImg){
                e.textContent = name.textContent + ' đã gửi một ảnh';
                if(type == 'en'){
                    if(name.textContent == 'Bạn'){
                        name.textContent = 'You';
                    }
                    e.textContent = name.textContent + ' send an image';
                }
                timeConversationElements[idx].textContent = time.textContent;
            }
            else if(contentFile){
                e.textContent = name.textContent + ' đã gửi một file';
                if(type == 'en'){
                    if(name.textContent == 'Bạn'){
                        name.textContent = 'You';
                    }
                    e.textContent = name.textContent + ' send a file';
                }
                timeConversationElements[idx].textContent = time.textContent;
            }
            else if(contentDelete){
                e.textContent = name.textContent + ': ' + 'Đã xóa tin nhắn';
                if(type == 'en'){
                    if(name.textContent == 'Bạn'){
                        name.textContent = 'You';
                    }
                    e.textContent = name.textContent + ': ' + 'Deleted a message';
                }
                timeConversationElements[idx].textContent = time.textContent;
            }           
            else{
                e.textContent = 'Chưa có tin nhắn';
                if(type == 'en'){
                    e.textContent = 'No message';
                }
                timeConversationElements[idx].textContent = '';
            }
        });

        // reload messages of conversationChosen
        if(currentConversation != -1){
            if(messageAreaElement){
                let lastMessage = conversations[currentConversation];
                let type = settingConfig.language;
                if(!beforeMessages[currentConversation] && beforeMessages[currentConversation] != ''){
                    beforeMessages[currentConversation] = conversations[currentConversation];
                    initLanguage();
                }
                else if(beforeMessages[currentConversation] != lastMessage){
                    areaMessageElement.innerHTML = conversations[currentConversation];
                    initLanguage();
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
        inputChatElement.placeholder = 'Gửi tin nhắn tới ' + namePaticipantElement.textContent;
        initLanguage();
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

            let type = settingConfig.language;
            if(type == 'en' && status){
                let statusStrs = status.split(' ');
                let statusStr = statusStrs[0] + ' ' + statusStrs[1] + ' ' + 'minutes ago';
                timePaticipantElement.textContent = statusStr;
                console.log(statusStr);
            }
            console.log(status);
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

searchInputElement.addEventListener('focus', () => {
    const conversationMainElement = document.querySelector('.list-conversation .conversations .conversations__main');
    const resultMainElement = document.querySelector('.list-conversation .search-bar__result');
    const conversationTitle1Element = document.querySelector('.list-conversation .conversations .conversations__title > span:first-child');
    const conversationTitle2Element = document.querySelector('.list-conversation .conversations .conversations__title > span:last-child');

    conversationMainElement.style = 'display: none;';
    resultMainElement.style = 'display: flex;';
    btnGroupShowElement.style = 'display: none';
    btnCloseSearchELement.style = 'display: flex';
    conversationTitle1Element.style = 'display: none;';
    conversationTitle2Element.style = 'display: inline;';
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
        initLanguage();
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
    const conversationTitle1Element = document.querySelector('.list-conversation .conversations .conversations__title > span:first-child');
    const conversationTitle2Element = document.querySelector('.list-conversation .conversations .conversations__title > span:last-child');

    conversationMainElement.style = 'display: flex;';
    resultMainElement.style = 'display: none;';
    btnGroupShowElement.style = 'display: flex';
    btnCloseSearchELement.style = 'display: none';
    conversationTitle1Element.style = 'display: inline;';
    conversationTitle2Element.style = 'display: none;';
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

// setting click
const btnSettingElement = document.querySelector('#setting');
const areaSettingElement = document.querySelector('.setting');
const btnCloseSettingElement = document.querySelector('.setting .setting-main .menu-right > .title > i');
const btnMenuLeftElements = document.querySelectorAll('.setting .setting-main .menu-left > .menu-left-main > .menu-left-main__item');
const btnMenuLeftGeneralElement = document.querySelector('.setting .setting-main .menu-left > .menu-left-main > #generalSetting');
const btnMenuLeftThemeElement = document.querySelector('.setting .setting-main .menu-left > .menu-left-main > #themeSetting');
const areaGeneralDetailElement = document.querySelector('.setting .setting-main .menu-right > #generalDetail');
const areaThemeDetailElement = document.querySelector('.setting .setting-main .menu-right > #themeDetail');
const selectLanguageElement = document.querySelector('.setting .setting-main .menu-right .menu-right-main > .menu-right-main__item > .detail > select');
const selectLightThemeElement = document.querySelector('.setting .setting-main .menu-right .menu-right-main > .menu-right-main__item > .detail > input[value="light"]');
const selectDarkThemeElement = document.querySelector('.setting .setting-main .menu-right .menu-right-main > .menu-right-main__item > .detail > input[value="dark"]');

btnSettingElement.addEventListener('click', () => {
    areaSettingElement.style = 'display: flex';
    let optionViElement = selectLanguageElement.querySelector('option[value="vi"]');
    let optionEnElement = selectLanguageElement.querySelector('option[value="en"]');   
    let typeLanguage = settingConfig.language;
    if(typeLanguage == 'vi'){
        optionViElement.selected = 'selected';
    }
    if(typeLanguage == 'en'){
        optionEnElement.selected = 'selected';
    }
    let typeTheme = settingConfig.theme;
    if(typeTheme == 'light'){
        selectLightThemeElement.checked = true;
    }
    if(typeTheme == 'dark'){
        selectDarkThemeElement.checked = true;
    }
});
btnCloseSettingElement.addEventListener('click', () => {
    areaSettingElement.style = 'display: none';
});
function resetColorBtnMenuLeft(){
    btnMenuLeftElements.forEach((e) => {
        e.classList.remove('menu-left-main__item--choice');
    })
}
btnMenuLeftElements.forEach((e) => {
    e.addEventListener('click', (ev) => {
        resetColorBtnMenuLeft();
        e.classList.add('menu-left-main__item--choice');
    });
});
btnMenuLeftGeneralElement.addEventListener('click', () => {
    areaGeneralDetailElement.style = 'display: flex';
    areaThemeDetailElement.style = 'display: none';
});
btnMenuLeftThemeElement.addEventListener('click', () => {
    areaGeneralDetailElement.style = 'display: none';
    areaThemeDetailElement.style = 'display: flex';
});
selectLanguageElement.addEventListener('input', () => {
    settingConfig.language = selectLanguageElement.value;
    setCookie('setting', JSON.stringify(settingConfig), 1);
    initLanguage();
});
selectLightThemeElement.addEventListener('input', () => {
    settingConfig.theme = 'light';
    setCookie('setting', JSON.stringify(settingConfig), 1);
    initTheme();
});
selectDarkThemeElement.addEventListener('input', () => {
    settingConfig.theme = 'dark';
    setCookie('setting', JSON.stringify(settingConfig), 1);
    initTheme();
});

var settingConfig = JSON.parse(getCookie('setting'));
function getCookie(name){
    let cookieStr = decodeURIComponent(document.cookie);
    let cookieStrs = cookieStr.split(';');
    for(let i = 0; i < cookieStrs.length; i++){
        let cookiePair = cookieStrs[i].split('=');
        let key = cookiePair[0].trim();
        let value = cookiePair[1].trim();
        if(key == name){
            return value;
        }
    }
    return "";
}
function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function initLanguage(){
    let type = settingConfig.language;
    const h2MesageElement = document.querySelector('#message h2');
    const h2FriendElement = document.querySelector('#friend h2');
    const conversationTitleElement = document.querySelector('.list-conversation .conversations .conversations__title');
    const fastChatElement = document.querySelector('.chat-area__main .area-send .area-send__toolbar > .fast-menu > .fast-menu__main');
    const titleSettingElement = document.querySelector('.setting .setting-main .menu-left > .title');
    const titleSetting2Element = document.querySelector('.setting .setting-main .menu-right #generalDetail > .menu-right-main__item > .title');
    const titleSetting3Element = document.querySelector('.setting .setting-main .menu-right .menu-right-main > .menu-right-main__item > .detail > .title');
    const optionViElement = selectLanguageElement.querySelector('option[value="vi"]');
    const titleSetting4Element = document.querySelector('.setting .setting-main .menu-right #themeDetail > .menu-right-main__item > .title');
    const titleGroupElement = document.querySelector('.group-create__form form > .title > p');
    const inputNameGroupElement = document.querySelector('.group-create__form form > .info > input');
    const titleSearchGroupElement = document.querySelector('.group-create__form form > .add-people > p:first-child');
    const inputSearchGroupElement = document.querySelector('.group-create__form form > .add-people > input');
    const titleAllGroupElement = document.querySelector('.group-create__form form > .add-people > p:last-child');
    const btnCancerGroupElement = document.querySelector('.group-create__form form > .btns > p:first-child');
    const btnCreateGroupElement = document.querySelector('.group-create__form form > .btns > input[type="submit"]');
    const titleSliderElement = document.querySelector('.chat-area__intro > .title');
    const introSliderElement = document.querySelector('.chat-area__intro > .content');
    const titleSlide1Element = document.querySelector('.slider-bar .slider-bar__slides > #s1 > .title');
    const contentSlide1Element = document.querySelector('.slider-bar .slider-bar__slides > #s1 > .content');
    const titleSlide2Element = document.querySelector('.slider-bar .slider-bar__slides > #s2 > .title');
    const contentSlide2Element = document.querySelector('.slider-bar .slider-bar__slides > #s2 > .content');
    const titleSlide3Element = document.querySelector('.slider-bar .slider-bar__slides > #s3 > .title');
    const contentSlide3Element = document.querySelector('.slider-bar .slider-bar__slides > #s3 > .content');
    const inputSearchFriendElement = document.querySelector('.list-conversation .search-bar > #input-data');
    const titleFriendElement = document.querySelector('#Friends .list-conversation .conversations');
    const title2FriendElement = document.querySelector('.search-filter .content h2');
    const resultSearchFriendElement = document.querySelector('.search-filter .content .main-filter');
    const resultSearch2FriendElement = document.querySelector('.list-conversation .search-bar__result');

    if(type == 'en'){
        h2MesageElement.textContent = "Message";
        h2FriendElement.textContent = "Friend";
        btnSettingElement.querySelector('h2').textContent = "Setting";
        searchInputElement.placeholder = 'My friend';
        btnCloseSearchELement.textContent = 'Close';
        conversationTitleElement.innerHTML = `
            <span>All messages<i class="fas fa-chevron-down" style="margin-left: 5px;"></i></span>
            <span style="display: none;">Friend<i class="fas fa-chevron-down" style="margin-left: 5px;"></i></span>
        `;
        inputChatElement.placeholder = inputChatElement.placeholder.replace('Gửi tin nhắn tới','Send a message to');
        fastChatElement.innerHTML = `
            <p>Hello</p>
            <p>GoodBye</p>
            <p>See you again</p>
            <p>Nice to meet you</p>
        `;
        choiceFastChat();
        areaMessageElement.innerHTML = areaMessageElement.innerHTML.replaceAll(
            ">Bạn<",
            ">You<"
        );
        titleSettingElement.textContent = 'Setting';
        btnMenuLeftGeneralElement.querySelector('span').textContent = 'General';
        btnMenuLeftThemeElement.querySelector('span').textContent = 'Theme';
        titleSetting2Element.textContent = 'Language (Ngôn ngữ)';
        titleSetting3Element.textContent = 'Change language';
        optionViElement.textContent = 'Vietnamese';
        titleSetting4Element.textContent = 'Theme';
        selectLightThemeElement.parentElement.querySelector('span').textContent = 'Light (default)';
        selectDarkThemeElement.parentElement.querySelector('span').textContent = 'Dark (save power)';
        // group
        titleGroupElement.textContent = 'Create group';
        inputNameGroupElement.placeholder = 'Enter group name';
        titleSearchGroupElement.textContent = 'Add friend';
        inputSearchGroupElement.placeholder = 'Enter friend name';
        titleAllGroupElement.textContent = 'All';
        btnCancerGroupElement.textContent = 'Cancer';
        btnCreateGroupElement.value = 'Create';
        //slide
        titleSliderElement.innerHTML = 'Welcome to <span style="font-weight: 500;">ChatApp!</span>';
        introSliderElement.textContent = 'Explore chat apps online with people, connect friends, communicate anytime and anywhere.';
        titleSlide1Element.textContent = 'Beautiful app';
        contentSlide1Element.textContent = 'The application has an clear interface, easy to use';
        titleSlide2Element.textContent = 'Real-time chat';
        contentSlide2Element.textContent = 'Online chat, send fast message';
        titleSlide3Element.textContent = 'Send faster file';
        contentSlide3Element.textContent = 'Send big files, any files, anytime';
        //friend
        inputSearchFriendElement.placeholder = 'Search other';
        titleFriendElement.innerHTML = titleFriendElement.innerHTML.replaceAll(
            'Danh sách kết bạn',
            'Request list'
        );
        titleFriendElement.innerHTML = titleFriendElement.innerHTML.replaceAll(
            'Danh sách nhóm',
            'Group list'
        );
        titleFriendElement.innerHTML = titleFriendElement.innerHTML.replaceAll(
            'Danh sách bạn bè',
            'Friend list'
        );
        title2FriendElement.textContent = 'Search';
        resultSearchFriendElement.innerHTML = resultSearchFriendElement.innerHTML.replaceAll(
            'Kết bạn',
            'Request'
        );
        resultSearchFriendElement.innerHTML = resultSearchFriendElement.innerHTML.replaceAll(
            'Hủy kết bạn',
            'Cancer friend'
        );
        resultSearchFriendElement.innerHTML = resultSearchFriendElement.innerHTML.replaceAll(
            'Chấp nhận',
            'Accept'
        );
        resultSearchFriendElement.innerHTML = resultSearchFriendElement.innerHTML.replaceAll(
            'Bạn bè',
            'Friend'
        );
        resultSearchFriendElement.innerHTML = resultSearchFriendElement.innerHTML.replaceAll(
            'Hủy lời mời',
            'Cancer request'
        );
        resultSearch2FriendElement.innerHTML = resultSearch2FriendElement.innerHTML.replaceAll(
            'Bạn bè',
            'Friend'
        );
        resultSearch2FriendElement.innerHTML = resultSearch2FriendElement.innerHTML.replaceAll(
            'Nhắn tin',
            'Send'
        );
    }
    if(type == 'vi'){
        h2MesageElement.textContent = "Tin nhắn";
        h2FriendElement.textContent = "Bạn bè";
        btnSettingElement.querySelector('h2').textContent = "Cài đặt";
        searchInputElement.placeholder = 'Bạn bè';
        btnCloseSearchELement.textContent = 'Đóng';
        conversationTitleElement.innerHTML = `
            <span>Tất cả tin nhắn<i class="fas fa-chevron-down" style="margin-left: 5px;"></i></span>
            <span style="display: none;">Bạn bè<i class="fas fa-chevron-down" style="margin-left: 5px;"></i></span>
        `
        inputChatElement.placeholder = inputChatElement.placeholder.replace('Send a message to','Gửi tin nhắn tới');
        fastChatElement.innerHTML = `
            <p>Xin Chào</p>
            <p>Tạm biệt</p>
            <p>Hẹn gặp lại</p>
            <p>Hân hạnh làm quen</p>
        `;
        choiceFastChat();
        areaMessageElement.innerHTML = areaMessageElement.innerHTML.replaceAll(
            ">You<",
            ">Bạn<"
        );
        titleSettingElement.textContent = 'Cài đặt';
        btnMenuLeftGeneralElement.querySelector('span').textContent = 'Cài đặt chung';
        btnMenuLeftThemeElement.querySelector('span').textContent = 'Giao diện';
        titleSetting2Element.textContent = 'Ngôn ngữ (Language)';
        titleSetting3Element.textContent = 'Thay đổi ngôn ngữ';
        optionViElement.textContent = 'Tiếng việt';
        titleSetting4Element.textContent = 'Cài đặt giao diện';
        selectLightThemeElement.parentElement.querySelector('span').textContent = 'Sáng (mặc định)';
        selectDarkThemeElement.parentElement.querySelector('span').textContent = 'Tối (tiết kiệm pin)';
        // group
        titleGroupElement.textContent = 'Tạo nhóm';
        inputNameGroupElement.placeholder = 'Nhập tên nhóm';
        titleSearchGroupElement.textContent = 'Thêm bạn vào nhóm';
        inputSearchGroupElement.placeholder = 'Nhập tên';
        titleAllGroupElement.textContent = 'Tất cả';
        btnCancerGroupElement.textContent = 'Hủy';
        btnCreateGroupElement.value = 'Tạo nhóm';
        //slide
        titleSliderElement.innerHTML = 'Chào mừng đến với <span style="font-weight: 500;">ChatApp!</span>';
        introSliderElement.textContent = 'Khám phá ứng dụng trò chuyện trực tuyến với mọi người, kết bạn, giao lưu mọi nơi mọi lúc.';
        titleSlide1Element.textContent = 'Giao diện trực quan';
        contentSlide1Element.textContent = 'Ứng dụng có giao diện trực quan, rất dễ sử dụng';
        titleSlide2Element.textContent = 'Trò chuyện thời gian thực';
        contentSlide2Element.textContent = 'Trò chuyện trực tuyến, phản hồi tức thời';
        titleSlide3Element.textContent = 'Gửi file nhanh chóng';
        contentSlide3Element.textContent = 'Gửi file nặng, bất kì file nào, bất cứ lúc nào';
        //friend
        inputSearchFriendElement.placeholder = 'Tìm kiếm';
        titleFriendElement.innerHTML = titleFriendElement.innerHTML.replaceAll(
            'Request list',
            'Danh sách kết bạn'
        );
        titleFriendElement.innerHTML = titleFriendElement.innerHTML.replaceAll(
            'Group list',
            'Danh sách nhóm'
        );
        titleFriendElement.innerHTML = titleFriendElement.innerHTML.replaceAll(
            'Friend list',
            'Danh sách bạn bè'
        );
        title2FriendElement.textContent = 'Tìm kiếm';
        resultSearchFriendElement.innerHTML = resultSearchFriendElement.innerHTML.replaceAll(
            'Request',
            'Kết bạn'
        );
        resultSearchFriendElement.innerHTML = resultSearchFriendElement.innerHTML.replaceAll(
            'Cancer friend',
            'Hủy kết bạn'
        );
        resultSearchFriendElement.innerHTML = resultSearchFriendElement.innerHTML.replaceAll(
            'Accept',
            'Chấp nhận'
        );
        resultSearchFriendElement.innerHTML = resultSearchFriendElement.innerHTML.replaceAll(
            'Friend',
            'Bạn bè'
        );
        resultSearchFriendElement.innerHTML = resultSearchFriendElement.innerHTML.replaceAll(
            'Cancer request',
            'Hủy lời mời'
        );
        resultSearch2FriendElement.innerHTML = resultSearch2FriendElement.innerHTML.replaceAll(
            'Friend',
            'Bạn bè'
        );
        resultSearch2FriendElement.innerHTML = resultSearch2FriendElement.innerHTML.replaceAll(
            'Send',
            'Nhắn tin'
        );
    }
}
function initTheme(){
    let type = settingConfig.theme;
    const dashboardElement = document.querySelector('.dashboard');
    const h2DashBoardElement = document.querySelectorAll('.links h2');
    const aLinkDastBoardElement = document.querySelectorAll('.links a');
    const h3DashBoardElement = document.querySelector('.dashboard h3');
    const mainElement = document.querySelector('main');
    const styleElement = document.querySelector('style');

    if(type == 'light'){
        dashboardElement.style = '';
        h2DashBoardElement.forEach((e) => {
            e.style = '';
        });
        aLinkDastBoardElement.forEach((e) => {
            e.style = '';
        });
        h3DashBoardElement.style = '';
        mainElement.style = '';
        styleElement.textContent = '';
    }
    if(type == 'dark'){
        dashboardElement.style = 'background-color: rgb(0 0 0);';
        h2DashBoardElement.forEach((e) => {
            e.style = 'color: white;';
        });
        aLinkDastBoardElement.forEach((e) => {
            e.style = 'color: white;';
        });
        h3DashBoardElement.style = 'color: white;';
        mainElement.style = 'background: linear-gradient(to right top, #000000, #6cdbeb);';
        styleElement.textContent = `
        .chat-area__main .area-send .area-send__input > input::placeholder {
            color: white;
            opacity: 0.5;
          }
        `;
    }
}
initLanguage();
initTheme();