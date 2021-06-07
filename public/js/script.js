document.addEventListener('DOMContentLoaded', function() {
    $('.voovolta').hide();;
});

function VooVolta(){
    if(document.querySelector('.voovolta').style.display == 'none'){
        $('.voovolta').show();
    }else{
        $('.voovolta').hide();
    }
}