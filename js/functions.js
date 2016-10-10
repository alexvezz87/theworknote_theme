$( document ).ready(function() {
    
    //apro e chiudo l'hamburger menu del mobile
    $('.hambuger-menu').click(function(){
        $('.mobile-menu').show("slide", { direction: "right" }, 400);   
    });
    
    $('.mobile-menu .chiudi').click(function(){
        $('.mobile-menu').hide("slide", { direction: "right" }, 400); 
        $('.mobile-menu .sotto-menu').hide();
    });
    
    $('.mobile-menu').on('swipe', function(){
        $('.mobile-menu').hide("slide", { direction: "right" }, 400); 
        $('.mobile-menu .sotto-menu').hide();
    });
    
    //rimuovo l'admin bar standard
    if($('body.not-admin').size() > 0){
        $('body.not-admin #wpadminbar').remove();
        
        if($(window).width() > 782){
            $('header').css('margin-top', '-32px');
        }
        else{
            $('header').css('margin-top', '-46px');
        }
    }
    
    $(window).resize(function(){
        if($('body.not-admin').size() > 0){
            if($(window).width() > 782){
                $('header').css('margin-top', '-32px');
            }
            else{
                $('header').css('margin-top', '-46px');
            }
        }
    });
    
    //Gestione sottomenu
    $('.icona').click(function(event){        
        event.stopPropagation(); //IMPORANTE!
        //nascondo tutto
        hideSubMenus();
       
        //Mostro il triangolo
        $(this).find('.triangolo').show();
        //Mostro il submenus
        $('.submenus').show();
        //Mostro il submenu giusto
        $('.submenus div[data-name='+$(this).data('name')+']').show();
    });
    
    //nascondo tutto se clicco fuori
    $('html').click(function(){
        //nascondo tutto
        hideSubMenus();
    });
    
    function hideSubMenus(){
       //nascondo tutti i triagoli visibili
       $('.triangolo').hide();
       //nascondo il submenus
       $('.submenus').hide();
       //nascondo i suoi figli
       $('.sub-menu').hide();
    }
    
    //Gestione menu mobile
    $('.mobile-menu .riga, .mobile-menu .icona').click(function(){
       
       
        if($(this).hasClass('riga')){
            $(this).find('.sotto-menu').slideToggle();
        }
        else{
            $(this).siblings('.sotto-menu').slideToggle();
        }
    });
    
    /** PAGINA REGISTRAZIONE **/
    if($('.registrazione').size()>0){
        //eseguo qualche accrocchio, tra i quali spostare alcuni field in fondo alla pagina
        $('.field_immagine-aziendale, .field_privacy').appendTo('#last-options');
                
        
        $('.field_tipo-societa select option[value=""]').html('Tipo Società');
        $('.field_categoria-commerciale select option[value=""]').html('Categoria commerciale');
        
        //sposto l'indirizzo sotto al numero di telefono
        $('.field_indirizzo, .field_n-civico, .field_cap, .field_citta, .field_provincia').insertAfter('.field_contatto-telefonico');
        
        
    }
    
        
    //listner sul SUBMIT della ricerca in sidebar
    $('.sidebar #motore-ricerca input[type=submit]').click(function(){
        //devo controllare che almeno un campo sia stato compilato
        //non è permessa la ricerca senza almeno un campo compilato
        
        var compilato = 0;
        $('.sidebar #motore-ricerca input[type=text]').each(function(){
            if($.trim($(this).val()) !== ''){
                compilato++;
            }
        });
        $('.sidebar #motore-ricerca select').each(function(){
            if($(this).val() !== ''){
                compilato++;
            }
        });            
        
        if(compilato === 0){
            alert('Per effettuare una ricerca bisogna almeno inserire un campo');
            return false;       
        }
    });
    //listner sul SUBMIT della ricerca in mobile
    $('.ricerca-mobile #motore-ricerca input[type=submit]').click(function(){
        //devo controllare che almeno un campo sia stato compilato
        //non è permessa la ricerca senza almeno un campo compilato
        
        var compilatoM = 0;
        $('.ricerca-mobile #motore-ricerca input[type=text]').each(function(){
            if($.trim($(this).val()) !== ''){
                compilatoM++;
            }
        });
        $('.ricerca-mobile #motore-ricerca select').each(function(){
            if($(this).val() !== ''){
                compilatoM++;
            }
        });            
        
        if(compilatoM === 0){
            alert('Per effettuare una ricerca bisogna almeno inserire un campo');
            return false;       
        }
    });
    //listener sul SUBMIT della ricerca in pagina non-registrato
    $('.non-registrato #motore-ricerca input[type=submit]').click(function(){
        //devo controllare che almeno un campo sia stato compilato
        //non è permessa la ricerca senza almeno un campo compilato
        
        var compilatoM = 0;
        $('.non-registrato #motore-ricerca input[type=text]').each(function(){
            if($.trim($(this).val()) !== ''){
                compilatoM++;
            }
        });
        $('.non-registrato #motore-ricerca select').each(function(){
            if($(this).val() !== ''){
                compilatoM++;
            }
        });            
          
        
        if(compilatoM === 0){
            alert('Per effettuare una ricerca bisogna almeno inserire un campo');
            return false;       
        }
    });
    
    
   
    //elimino gli 0 dai like-numbers
    $('.likes-number, .comment-number, .rs-count').each(function(){
        if($.trim($(this).text()) === '0'){
            $(this).text('');
        }
        if($.trim($(this).text()) === ''){
            
        }
    });    
        
    //accrocchio sulla struttura del reshare
    $('.reshare-button').each(function(){
        $(this).find('.rs-count').insertBefore($(this));
        $(this).html('');
    });
    
    
    //PAGINA NEGOZIO (../memebers/nome-membro)
    //sposto la copertina fuori dal container-1024
    
    $('#header-cover-image').appendTo('.main-container .pre-container-1024 #buddypress');
    
    
    //Gestione slider foto
    $('#info_gallery li').click(function(){
        //prendo il numero
        var slide = $(this).data('num');
        
        //nascondo le foto già presenti
        $('#container-slider-foto li').hide();
        $('#container-slider-foto li').removeClass('current');
        //visualizzo la foto corrispondente
        $('#container-slider-foto li[data-num='+slide+']').show();
        $('#container-slider-foto li[data-num='+slide+']').addClass('current');
        $('#container-slider-foto').show();
        $('body').css('overflow', 'hidden');
    });
    
    //gestione avanti e indietro
    $('#container-slider-foto .prec span').click(function(){
        //prendo il numero della foto visualizzato
        if($('#container-slider-foto .current').size() > 0 ){
            var slide = $('#container-slider-foto .current').data('num');
            if(slide > 1){
                slide = slide -1;
                //nascondo e visualizzo la slide precedente
                $('#container-slider-foto li').hide();
                $('#container-slider-foto li').removeClass('current');
                $('#container-slider-foto li[data-num='+slide+']').show();
                $('#container-slider-foto li[data-num='+slide+']').addClass('current');
                
            }
        }
    });
    
    $('#container-slider-foto .succ span').click(function(){
        var max = $('#container-slider-foto .slider-foto').data('slide');
        //prendo il numero della foto visualizzato
        if($('#container-slider-foto .current').size() > 0 ){
            var slide = $('#container-slider-foto .current').data('num');
            if(slide < max){
                slide = slide +1;
                //nascondo e visualizzo la slide precedente
                $('#container-slider-foto li').hide();
                $('#container-slider-foto li').removeClass('current');
                $('#container-slider-foto li[data-num='+slide+']').show();
                $('#container-slider-foto li[data-num='+slide+']').addClass('current');
                
            }
        }
    });
    
    $('#container-slider-foto .close-window span').click(function(){
        $('#container-slider-foto').hide();
        $('#container-slider-foto li').hide();
        $('#container-slider-foto li').removeClass('current');
        $('body').css('overflow', 'visible');
        
    });
    
    //chiamata ajax al commento
    $('.comment-container .comment-submit input[name=submit-button]').click(function(){
        var commento = new Object();
        commento.testo = $(this).parent('.comment-submit').siblings('.comment-text').find('textarea').val();
        commento.idUserCommenting = $(this).siblings('input[name=id-user-commenting]').val();
        commento.idUserCommented = $(this).siblings('input[name=id-user-commented]').val();
       
        if(commento.testo !== ''){
       
            $.ajax({
                type:'POST',
                dataType: 'json', 
                url : $(this).siblings('input[name=url]').val(),
                data: {
                    action : 'my_ajax',
                    commento : commento
                },
                success: function(data){
                    
                    printCommento(data);
                   
                },
                error: function(){
                    alert('error');
                }
            });
            
            $(this).parent('.comment-submit').siblings('.comment-text').find('textarea').val('');
            
        }else{
            alert('Per commentare scrivi qualcosa');
        }  
    });
    
    
    $(document).on('click', '.elimina-commento', function(){ 
        var idCommento = $(this).siblings('input[name=id]').val();       
        var idCommented = $('input[name=id-user-commented]').val();
        
        $.ajax({
            type:'POST',
            dataType:'json',
            url: $('input[name=url]').val(),
            data: {
                action : 'my_ajax',
                idCommento : idCommento,
                idCommented : idCommented
            },
            success: function(data){
               
                printCommento(data);
            },
            error: function(request, error) {
                alert(error);
            }
        });
    });
    
    function printCommento(data){
        //riscrivo la nuova colonna dei commenti
        $('.colonna-commenti').html('');
        var idUserCommenting = $('input[name=id-user-commenting]').val();
        var html='';
        
        if(data.length > 0){
            for(var i=0; i < data.length; i++){
                html+='<div class="container-commento">';
                
                if(data[i].idUserCommenting == idUserCommenting || data[i].idUserCommented == idUserCommenting){
                    html+='<a class="elimina-commento">X</a>';
                    html+='<input type="hidden" name="id" value="'+data[i].ID+'" />';                                     
                }            
                html+='<div class="header-commento">';
                html+='<a href="'+data[i].url+'">'+data[i].avatar+'</a>';
                html+='<a href="'+data[i].url+'"><span class="nome">'+data[i].nome+'</span></a>';
                html+='<span class="time">'+data[i].time+'</span>';
                html+='</div>';
                html+='<div class="comment-text">'+data[i].commento+'</div>';
                html+='</div>';
            }
        }
        else{
            html = '<p>Non ci sono commenti da visualizzare</p>';
        }

        $('.colonna-commenti').html(html);
    }
    
    //scroll on commenta
    $('#cover-image-container .commenta').click(function(){
        if($(window).width() > 767){
            $('html, body').animate({
                scrollTop: $(".form-not-mobile #title-commenti").offset().top
            }, 2000);
        }
        else{
             $('html, body').animate({
                scrollTop: $(".form-mobile #title-commenti").offset().top
            }, 2000);
        }
    });
    
    //effetto su textarea dei commenti
    $('html').click(function() {
        $('.comment-container .comment-text textarea').animate({
            height : "35px"
        });
    });
    $('.comment-container .comment-text textarea').click(function(event){
       
        $(this).animate({
            height : "60px"
        });
         event.stopPropagation();
    });
    
    
    //PAGINA PREFERENZE
        
        //select all 
    $("input[name=select-all]").click(function(){
        //becco il padre
        var $form = $(this).parent('div').parent('form');
        $form.find('input.sottocategorie').attr('checked', 'true');
        $form.find('input.sottocategorie').prop('checked', true);
        $(this).hide();
        $(this).siblings('label').hide();
        $(this).siblings('input').show();
        $(this).siblings('input.deselect-all + label').show();
    });
    //deselect all
    $("input[name=deselect-all]").click(function(){
        //becco il padre
        var $form = $(this).parent('div').parent('form');
        $form.find('input.sottocategorie').removeAttr('checked');
        $form.find('input.sottocategorie').prop('checked', false);
        $(this).hide();
        $(this).siblings('label').hide();
        $(this).siblings('input').show();
        $(this).siblings('input.select-all + label').show();
    });

    //rimuovi proposto
    $("input[name=rimuovi-proposto]").click(function(){       
       
        var idUtente = $(this).siblings('input[name=id-utente]').val();
        var idUtenteProposto = $(this).siblings('input[name=id-utente-proposto]').val();
        var $objectLi = $(this).parent('form').parent('div.buttons').parent('li');
        var $objectUl = $objectLi.parent('ul.matching');
        var liWidth = $objectUl.parent('.container-ul').parent('.carusel').siblings('input[name=liWidth]');
        
        //alert('id1: '+idUtente+' id2: '+idUtenteProposto);
        $.ajax({
            type:'POST',
            dataType: 'json',
            url: $('input[name=url]').val(),
            data: {
                action : 'remove_proposto',
                idUtente : idUtente,
                idUtenteProposto: idUtenteProposto
            },
            success : function(data){
                fadeOutLi(data, $objectLi, $objectUl, liWidth);
            },
            error : function(){
                alert('error');
            }

        });
    });

    function fadeOutLi(data, li, ul, liWidth){
        if(data == true){
            li.remove();
                     
            var ulWidth = ul.css('width').replace('px', '');
            
            ulWidth  = ulWidth - liWidth.val();            
            ul.css('width', ulWidth+'px');
            ul.css('margin-left', '0px');
            
            if(ul.find('li').size() == 0){
                //se non ci sono più elementi se sono nel caso del widget, elimino al cosa
                if( liWidth.siblings('input[name=isWidget]').size()> 0){
                    liWidth.siblings('.pagina-matching.carusel').remove();
                    liWidth.siblings('.banner').remove();
                }
                else{
                    liWidth.siblings('.pagina-matching.carusel').html('<p class="no-match">NESSUN UTENTE CORRISPONDE ALLE TUE PREFERENZE</p>');  
                }
            }
        }
    }
    
    
    //REGISTRAZIONE
    if($('.registrazione #registration-complete').size() > 0){
        $('#visible-boxed').show();
    }
    
    
    //MATCHING
    
    if($('.pagina-matching.carusel').size() > 0){
        $('.arrow.indietro, .arrow.avanti').click(function(){
            
            var carusel = $(this).parent('.carusel');
            var matching = $(this).siblings('.container-ul').find('.matching');
            
            var liWidth = carusel.siblings('input[name=liWidth]').val();
            var ulWidthOr = carusel.siblings('input[name=ulWidth]').val();
            
            var margin = matching.css('margin-left').replace('px', '');
            var ulWidth = matching.css('width').replace('px', '');
           
            //indietro
            if($(this).hasClass('indietro')){
                if(parseInt(ulWidth) + parseInt(margin) > ulWidthOr){
                    matching.stop().animate({
                        marginLeft: '-='+liWidth+'px'
                    }, 500);
                }
            }
            
            //avanti
            if($(this).hasClass('avanti')){
                if(margin < 0){
                    $(this).siblings('.container-ul').find('.matching').stop().animate({
                        marginLeft: '+='+liWidth+'px'
                    }, 500);
                }
            }
            
        });        
    }
    
    //SELEZIONA AL MASSIMO 10 PERFERENZE
    $('input.sottocategorie').click(function(){
        //ho cliccato sull'input, ora controllo quante sono le scelte effettuate
        //setto il counter a 0
        //var counter = 0;
        //ottengo il padre
        var form = $(this).parent('label').parent('li').parent('ul').parent('.categorie-list').parent('.container-categoria').parent('form');
        //trovo tutti gli input
        var counter = form.find('input.sottocategorie:checked').size();
        
        if(counter > 20){
            //se il counter ha superato le 10 unità non posso selezionare questo input
            $(this).prop( "checked", false );
            alert('Hai già selezionato 20 preferenze');
        }
            
        
        
    });
    
    
    //Invia messaggio
    $('#buddypress #item-header-cover-image .container-boxes > div a.email').click(function(){
        $('#invio-mail').show();
    });
    
    $('.container-invio-mail .close-window').click(function(){
        $('#invio-mail').hide();
            
    });
    
    //listener su invia messaggio
    $('.container-invio-mail .invia').click(function(){
       //controllo se tutti i campi sono compilati
       var empty = false;
       $('.container-invio-mail input').each(function(){
           if($(this).val() == ''){
               empty = true;
           }
       });
       
       if($('.container-invio-mail textarea').val() == ''){
           empty = true;
       }       
       
       if(!$('.container-invio-mail input[name=privacy]').is(":checked")){
           empty = true;
       }
       
       
       if(empty == true){
           alert('Campi obbligatori mancanti!');
       }
       
        if(empty == false){
            if(!isValidEmailAddress($('.container-invio-mail input[name=email]').val())){
                alert('Email non valida');
            }
            else{
                //campi non vuoti ed email valida, procedo all'invio del messaggio e il registro del log
                var idDestinatario = $('.container-invio-mail input[name=idDestinatario]').val();                
                var nomeMittente = $('.container-invio-mail input[name=nome]').val();
                var emailMittente = $('.container-invio-mail input[name=email]').val();
                var oggetto = $('.container-invio-mail input[name=oggetto]').val();
                var messaggio = $('.container-invio-mail textarea').val();
                
                $.ajax({
                    type:'POST',
                    dataType: 'json',
                    url: $('.container-invio-mail input[name=url]').val(),
                    data: {
                        action : 'log_email',
                        idDest : idDestinatario,                       
                        nomeMitt : nomeMittente,
                        emailMitt : emailMittente,
                        oggetto : oggetto,
                        messaggio : messaggio
                    },
                    success : function(data){
                       if(data == true){
                           //nascondo il form della mail
                           $('.container-invio-mail').hide();
                           //pulisco i campi di oggetto e testo
                           $('.container-invio-mail input[name=oggetto]').val('');
                           $('.container-invio-mail textarea').val('');
                           //visualizzo l'ok del messaggio
                           $('.message-ok').show();
                       }
                    },
                    error : function(){
                        alert('error');
                    }

                });
            }
        }
       
    });
    
    $('.chiudi-finestra').click(function(){
        $('.message-ok').hide();
    });
    
    
    //LISTENER scopri numero telefono
    $('#find-numero').click(function(){
        var idBPUser = $(this).siblings('input[name=idBPUser]').val();
        var idWPUser = $(this).siblings('input[name=idWPUser]').val();
        
        $.ajax({
            type:'POST',
            dataType: 'json',
            url: $('.container-invio-mail input[name=url]').val(),
            data: {
                action : 'log_tel',
                idBPUser : idBPUser,
                idWPUser : idWPUser                
            },
            success : function(data){
               $('span.numero').html(data);
               $('#find-numero').remove();
            },
            error : function(){
                alert('error');
            }

        });
        
    });
    
    
    
    
});

function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
};


