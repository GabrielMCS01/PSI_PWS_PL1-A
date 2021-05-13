$(document).ready(function(){
    //Escolher_imagem("login");
    //Verifica se login está correto
    if(localStorage.getItem('loginerror') == "true"){
        $("#mensagem").text("Username ou password incorreto.")
        .css({"position": "absolute", "margin-left": "4vw", "color": "red"});
    }
    localStorage.removeItem('loginerror');
    localStorage.removeItem('username');

    //Efeito para voltar da página createaccount
    if(localStorage.getItem('createback') == "true"){
        EfeitoBack();
    }
});