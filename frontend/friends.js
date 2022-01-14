$(document).ready(function(){
    
    $('#input-data').keyup(
        function(){
        var txt = $('#input-data').val();
        $.post('ajax.php', {data: txt}, function(data){
            $('.main-filter').html(data);
        })
        .then(() => {
            reloadBtns();
        })
        
    })
})



let testE = document.querySelector('.search-filter');

function reloadBtns(){
    let btnRequests = document.querySelectorAll('.search-filter .content .main-filter .information-card .request');
    btnRequests.forEach((e) => {
        e.addEventListener('click', requestFriend);
    });

    let btnCancelRequests = document.querySelectorAll('.search-filter .content .main-filter .information-card .cancel-request');
    btnCancelRequests.forEach((e) => {
        e.addEventListener('click', cancelRequests);
    });

    let btnAcceptRequests = document.querySelectorAll('.search-filter .content .main-filter .information-card .accept-request');
    btnAcceptRequests.forEach((e) => {
        e.addEventListener('click', acceptRequest);
    });

    let btnCancelFriends = document.querySelectorAll('.search-filter .content .main-filter .information-card .cancel-friend');
    btnCancelFriends.forEach((e) => {
        e.addEventListener('click', cancelFriend);
    });;
}

function requestFriend(ev){
    let btnElement = ev.target; 
    if(btnElement.tagName != 'BUTTON'){
        btnElement = btnElement.parentElement;
    }
    let idOther = btnElement.id;
    let ajax = new XMLHttpRequest();
    ajax.open('GET', 'ajax.php/?sendRequest=' + idOther);
    ajax.onload = () => {
        alert('Gửi kết bạn thành công');
        btnElement.textContent = 'Hủy lời mời';
        btnElement.removeEventListener('click', requestFriend);
        btnElement.classList.remove('request');
        btnElement.classList.add('cancel-request');
        reloadBtns();
    }
    ajax.send();
}

function cancelRequests(ev){
    let btnElement = ev.target;   
    if(btnElement.tagName != 'BUTTON'){
        btnElement = btnElement.parentElement;
    }
    let idOther = btnElement.id;
    let ajax = new XMLHttpRequest();
    ajax.open('GET', 'ajax.php/?cancelRequest=' + idOther);
    ajax.onload = () => {
        alert('Hủy lời mời thành công');
        btnElement.innerHTML = "<span class='material-icons'>person_add</span>Kết bạn";
        btnElement.removeEventListener('click', cancelRequests);
        btnElement.classList.add('request');
        btnElement.classList.remove('cancel-request');
        reloadBtns();
    }
    ajax.send();
}

function acceptRequest(ev){
    let btnElement = ev.target;   
    if(btnElement.tagName != 'BUTTON'){
        btnElement = btnElement.parentElement;
    }
    let idOther = btnElement.id;
    let ajax = new XMLHttpRequest();
    ajax.open('GET', 'ajax.php/?acceptRequest=' + idOther);
    ajax.onload = () => {
        alert('Chấp nhận lời mời thành công');
        btnElement.textContent = 'Hủy kết bạn';
        btnElement.removeEventListener('click', acceptRequest);
        btnElement.classList.remove('accept-request');
        btnElement.classList.add('cancel-friend');
        reloadBtns();
    }
    ajax.send();
}

function cancelFriend(ev){
    let btnElement = ev.target;   
    if(btnElement.tagName != 'BUTTON'){
        btnElement = btnElement.parentElement;
    }
    let idOther = btnElement.id;
    let ajax = new XMLHttpRequest();
    ajax.open('GET', 'ajax.php/?cancelFriend=' + idOther);
    ajax.onload = () => {
        alert('Hủy kết bạn thành công');
        btnElement.innerHTML = "<span class='material-icons'>person_add</span>Kết bạn";
        btnElement.removeEventListener('click', cancelFriend);
        btnElement.classList.add('request');
        btnElement.classList.remove('cancel-friend');
        reloadBtns();
        console.log(ajax.responseText);
    }
    ajax.send();
}
