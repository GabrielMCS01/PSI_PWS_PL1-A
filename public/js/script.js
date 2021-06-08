document.addEventListener('DOMContentLoaded', function() {
    $('.voovolta').hide();;
});

function VooVolta(){
    // Verifica se o item da class está visivel, se não estiver muda para visivel
    if(document.querySelector('.voovolta').style.display == 'none'){
        $('.voovolta').show();
        if(document.querySelector('#exibirPesquisa') != null) {
            document.querySelector('#exibirPesquisa').style.transform = 'rotate(180deg)';
        }
    }else{
        $('.voovolta').hide();
        if(document.querySelector('#exibirPesquisa') != null) {
            document.querySelector('#exibirPesquisa').style.transform = 'rotate(0deg)';
        }
    }
}