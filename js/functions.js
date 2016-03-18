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
        if($('.sidebar #motore-ricerca select').val() !== ''){
            compilato++;
        }      
        
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
        if($('.ricerca-mobile #motore-ricerca select').val() !== ''){
            compilatoM++;
        }      
        
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
    
    
});


