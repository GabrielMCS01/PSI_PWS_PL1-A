$(document).ready(function(){
    //Escolher_imagem("createaccount");
    $('.firstline').css('display', 'none');
    $('.formulario-todo').css('display', 'none');
    $('.cardtwo').css({'width': '0', 'margin-left': '230px'});
    $('.cardtwo').animate({
        'width': '30.3vw',
        'margin-left': '0px'
    }, 'normal');
    setTimeout(function(){
        $('.firstline').css('display', 'flex');
        $('.formulario-todo').css('display', 'unset');
     }, 400);
     
     if(localStorage.getItem("error") == "email"){
        $("#mensagem").text("Email já existente.")
        .css({"position": "absolute", "margin-left": "4vw", "color": "red"});
        localStorage.removeItem("error");
     }else if(localStorage.getItem("error") == "nome"){
        $("#mensagem").text("Nome já existente.")
        .css({"position": "absolute", "margin-left": "4vw", "color": "red"});
        localStorage.removeItem("error");
     }
});