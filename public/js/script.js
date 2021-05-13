//Mensagem de username não preenchida
function InvalidMsg1(textbox) { 
  
    if (textbox.value === '') { 
        textbox.setCustomValidity 
              ('Insira um username');
    } else { 
        textbox.setCustomValidity(''); 
    } 

    return true; 
}

//Mensagem de password não preenchida
function InvalidMsg2(textbox) { 
  
    if (textbox.value === '') { 
        textbox.setCustomValidity 
              ('Insira uma password');
    } else { 
        textbox.setCustomValidity(''); 
    } 

    return true; 
}

//Mensagem de email não preenchida
function InvalidMsg3(textbox) { 
  
    if (textbox.value === '') { 
        textbox.setCustomValidity 
              ('Insira um email');
    } else { 
        textbox.setCustomValidity(''); 
    } 

    return true; 
}

//Efeito para quando se volta da página createaccount
function EfeitoBack(){
    $('.firstline').css('display', 'none');
    $('.formulario-todo').css('display', 'none');
    $('.Secondline').css('display', 'none');
    $('.cardtwo').css({'width': '0', 'margin-left': '230px'});
    $('.cardtwo').animate({
        'width': '30.3vw',
        'margin-left': '0px'
    }, 'normal');
    setTimeout(function(){
        $('.firstline').css('display', 'flex');
        $('.formulario-todo').css('display', 'unset');
        $('.Secondline').css('display', 'flex');
     }, 400);
     localStorage.removeItem('createback');
}

//Efeito e passagem para create account e vice-versa
function Rotate(escolha){
    let destino;
    if(escolha == "login"){
        $('.Secondline').css('display', 'none');
        destino = "/createaccount.php";
    }else if(escolha == "createaccount"){
        localStorage.setItem("createback", "true");
        destino = "/login.php";
    }
    $('.firstline').css('display', 'none');
    $('.formulario-todo').css('display', 'none');
    $('.cardtwo').animate({
        'width': '0',
        'margin-left': '230px'
    }, 'normal');
    setTimeout(function(){
        window.location.replace(destino);
     }, 400);
}

//Escolher imagem de login
function Escolher_imagem(pagina){
    if(pagina == "login"){
        let imagem = Math.floor(Math.random() * 3) + ".jpg";
        let link = "url(../img/"+ pasta + "/" + imagem + ")";
        $('#imagemlogin').css('background-image', link);
        localStorage.setItem("fundo", link);
    }else if(pagina == "createaccount"){
        $('#imagemlogin').css('background-image', localStorage.getItem("fundo"));
    }
}