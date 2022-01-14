$(document).ready(function(){
    
    $('#input-data').keyup(
        function(){
        var txt = $('#input-data').val();
        $.post('ajax.php', {data: txt}, function(data){
            $('.main-filter').html(data);
        })
        .then(() => {
            init();
            init2();
        })
        
    })
})

let btnRequests;
let btnCancelRequests;
let btnAcceptRequest;
let btnCancelFriend;

function requestFriend(ev){
    let idOther = ev.target.id;
    let ajax = new XMLHttpRequest();
    ajax.open('GET', 'ajax.php/?sendRequest=' + idOther);
    ajax.onload = () => {
        alert('Gửi kết bạn thành công');
        ev.target.textContent = 'Hủy lời mời';
        ev.target.removeEventListener('click', requestFriend);
        ev.target.classList.remove('request');
        ev.target.classList.add('cancel-request');
        init2();
    }
    ajax.send();
}
function init(){
    btnRequests = document.querySelectorAll('.search-filter .content .main-filter .information-card .request');
    btnRequests.forEach((e) => {
        e.addEventListener('click', requestFriend);
    });
}
function CancelRequests(ev){
    let idOther = ev.target.id;
    let ajax = new XMLHttpRequest();
    ajax.open('GET', 'ajax.php/?cancelRequest=' + idOther);
    ajax.onload = () => {
        alert('Hủy lời mời thành công');
        ev.target.textContent = 'Kết bạn';
        ev.target.removeEventListener('click', CancelRequests);
        ev.target.classList.add('request');
        ev.target.classList.remove('cancel-request');
        init();
    }
    ajax.send();
}
function init2(){
    btnCancelRequests = document.querySelectorAll('.search-filter .content .main-filter .information-card .cancel-request');
    for(let i = 0; i < btnCancelRequests.length; i++){
        btnCancelRequests[i].addEventListener('click', CancelRequests);
    }
}

function acceptRequest(ev){
    let idOther = ev.target.id;
    let ajax = new XMLHttpRequest();
    ajax.open('GET', 'ajax.php/?acceptRequest=' + idOther);
    ajax.onload = () => {
        alert('Chấp nhận lời mời thành công');
        ev.target.textContent = 'Hủy kết bạn';
        ev.target.removeEventListener('click', acceptRequest);
        ev.target.classList.remove('accept-request');
        ev.target.classList.add('cancel-request');
        init2();
    }
    ajax.send();
}

function init3(){
    btnAcceptRequest = document.querySelector('.search-filter .content .main-filter .information-card .accept-request');
    btnAcceptRequest.forEach((e) => {
        e.addEventListener('click', acceptRequest);
    });
}
function CancelFriend(ev){
    let idOther = ev.target.id;
    let ajax = new XMLHttpRequest();
    ajax.open('GET', 'ajax.php/?cancelFriend=' + idOther);
    ajax.onload = () => {
        alert('Hủy kết bạn thành công');
        ev.target.textContent = 'Kết bạn';
        ev.target.removeEventListener('click', CancelFriend);
        ev.target.classList.add('request');
        ev.target.classList.remove('cancel-friend');
        init();
    }
    ajax.send();
}
function init4(){
    btnCancelFriend = document.querySelectorAll('.search-filter .content .main-filter .information-card .cancel-friend');
    for(let i = 0; i < btnCancelFriend.length; i++){
        btnCancelFriend[i].addEventListener('click', CancelFriend);
    }
}
