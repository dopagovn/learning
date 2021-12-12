$(document).ready(function(){
    
    $('#input-data').keyup(function(){
        var txt = $('#input-data').val();
        $.post('ajax.php', {data: txt}, function(data){
            $('.main-filter').html(data);
        })
    })
})

