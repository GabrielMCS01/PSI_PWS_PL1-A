document.addEventListener('DOMContentLoaded', function() {
    $('.voovolta').hide();
});

function VooVolta(){
    // Verifica se o item da class está visivel, se não estiver muda para visivel
    if(document.querySelector('.voovolta').style.display == 'none'){
        $('.voovolta').show();
        if(document.querySelector('#exibirPesquisa') != null) {
            console.log("ola");
            document.querySelector('#setabaixo').setAttribute('d','M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z');
        }
    }else{
        $('.voovolta').hide();
        if(document.querySelector('#exibirPesquisa') != null) {
            document.querySelector('#setabaixo').setAttribute('d', 'M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z');
        }
    }
}